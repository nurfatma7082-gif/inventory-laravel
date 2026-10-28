<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;

class SaleTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected User $staff;
    protected User $admin;
    protected Product $productA;
    protected Product $productB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create(['name' => 'Elektronik']);

        $this->productA = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-SALE-001',
            'name' => 'Flashdisk 32GB',
            'purchase_price' => 40000,
            'selling_price' => 60000,
            'stock' => 10,
            'minimum_stock' => 2,
        ]);

        $this->productB = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-SALE-002',
            'name' => 'Card Reader USB',
            'purchase_price' => 20000,
            'selling_price' => 35000,
            'stock' => 5,
            'minimum_stock' => 2,
        ]);
    }

    public function test_sale_decreases_stock_and_calculates_total_on_server(): void
    {
        $response = $this->actingAs($this->staff)->post('/sales', [
            'sold_at' => now()->format('Y-m-d H:i:s'),
            'notes' => 'Pembeli tunai',
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 3,
                ],
            ],
        ]);

        $response->assertSessionHasNoErrors();

        // Stok berkurang: 10 - 3 = 7
        $this->productA->refresh();
        $this->assertEquals(7, $this->productA->stock);

        // Server menghitung total: 3 * 60.000 = 180.000
        $this->assertDatabaseHas('sales', [
            'total' => 180000,
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('sale_items', [
            'product_id' => $this->productA->id,
            'quantity' => 3,
            'unit_price' => 60000,
            'subtotal' => 180000,
        ]);
    }

    public function test_insufficient_stock_rejects_sale_without_changing_data(): void
    {
        // Mencoba membeli 15 unit padahal stok hanya 10
        $response = $this->actingAs($this->staff)->post('/sales', [
            'sold_at' => now()->format('Y-m-d H:i:s'),
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 15, // Lebih dari stok 10!
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        // Pastikan stok TIDAK BERUBAH
        $this->productA->refresh();
        $this->assertEquals(10, $this->productA->stock);

        // Pastikan TIDAK ADA header sale tersimpan
        $this->assertDatabaseMissing('sales', [
            'user_id' => $this->staff->id,
        ]);
    }

    public function test_atomicity_rollback_when_one_item_in_multi_item_transaction_fails(): void
    {
        // Item 1 (productA) beli 2 (stok cukup, ada 10)
        // Item 2 (productB) beli 99 (stok tidak cukup, hanya ada 5)
        $response = $this->actingAs($this->staff)->post('/sales', [
            'sold_at' => now()->format('Y-m-d H:i:s'),
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 2,
                ],
                [
                    'product_id' => $this->productB->id,
                    'quantity' => 99, // Gagal disini
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        // Product A stoknya harus tetap 10 (tidak terpotong separuh / atomic rollback!)
        $this->productA->refresh();
        $this->assertEquals(10, $this->productA->stock);

        // Product B stoknya tetap 5
        $this->productB->refresh();
        $this->assertEquals(5, $this->productB->stock);

        // Tidak ada record sale sama sekali
        $this->assertEquals(0, Sale::count());
    }

    public function test_sale_cancel_restores_stock(): void
    {
        // Buat penjualan berhasil 4 unit
        $this->actingAs($this->staff)->post('/sales', [
            'sold_at' => now()->format('Y-m-d H:i:s'),
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 4,
                ],
            ],
        ]);

        $this->productA->refresh();
        $this->assertEquals(6, $this->productA->stock); // 10 - 4 = 6

        $sale = Sale::latest()->first();

        // Admin membatalkan penjualan
        $cancelResponse = $this->actingAs($this->admin)->post("/sales/{$sale->id}/cancel");
        $cancelResponse->assertSessionHasNoErrors();

        // Stok kembali ke 10
        $this->productA->refresh();
        $this->assertEquals(10, $this->productA->stock);

        $sale->refresh();
        $this->assertEquals('cancelled', $sale->status);
    }
}
