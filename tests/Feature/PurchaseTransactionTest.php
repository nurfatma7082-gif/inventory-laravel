<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected User $staff;
    protected User $admin;
    protected Supplier $supplier;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create(['name' => 'Elektronik']);
        $this->supplier = Supplier::create([
            'name' => 'PT Supplier Sukses',
            'phone' => '08123456789',
            'email' => 'supplier@sukses.com',
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-PO-001',
            'name' => 'Monitor 24 Inch',
            'purchase_price' => 1200000,
            'selling_price' => 1600000,
            'stock' => 5, // initial stock 5
            'minimum_stock' => 2,
        ]);
    }

    public function test_purchase_transaction_increases_stock_automatically(): void
    {
        $response = $this->actingAs($this->staff)->post('/purchases', [
            'supplier_id' => $this->supplier->id,
            'purchased_at' => now()->format('Y-m-d H:i:s'),
            'notes' => 'Pengadaan stok tambahan',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 10,
                    'unit_cost' => 1200000,
                ],
            ],
        ]);

        $response->assertSessionHasNoErrors();

        // Cek stok bertambah: 5 + 10 = 15
        $this->product->refresh();
        $this->assertEquals(15, $this->product->stock);

        // Cek transaksi tersimpan di database
        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $this->supplier->id,
            'status' => 'completed',
            'total' => 12000000,
        ]);

        $this->assertDatabaseHas('purchase_items', [
            'product_id' => $this->product->id,
            'quantity' => 10,
            'unit_cost' => 1200000,
            'subtotal' => 12000000,
        ]);
    }

    public function test_purchase_cancel_reverses_stock_increment(): void
    {
        // Buat pembelian
        $this->actingAs($this->staff)->post('/purchases', [
            'supplier_id' => $this->supplier->id,
            'purchased_at' => now()->format('Y-m-d H:i:s'),
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 5,
                    'unit_cost' => 1200000,
                ],
            ],
        ]);

        $this->product->refresh();
        $this->assertEquals(10, $this->product->stock); // 5 + 5

        $purchase = Purchase::latest()->first();

        // Admin batalkan pembelian
        $cancelResponse = $this->actingAs($this->admin)->post("/purchases/{$purchase->id}/cancel");
        $cancelResponse->assertSessionHasNoErrors();

        // Stok kembali ke semula (10 - 5 = 5)
        $this->product->refresh();
        $this->assertEquals(5, $this->product->stock);

        $purchase->refresh();
        $this->assertEquals('cancelled', $purchase->status);
    }
}
