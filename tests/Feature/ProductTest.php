<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->category = Category::create([
            'name' => 'Elektronik',
            'description' => 'Gadget dan aksesoris',
        ]);
    }

    public function test_can_create_product_with_valid_data(): void
    {
        $response = $this->actingAs($this->admin)->post('/products', [
            'sku' => 'PRD-TEST-001',
            'name' => 'Mouse Wireless',
            'category_id' => $this->category->id,
            'purchase_price' => 100000,
            'selling_price' => 150000,
            'stock' => 10,
            'minimum_stock' => 2,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'sku' => 'PRD-TEST-001',
            'name' => 'Mouse Wireless',
        ]);
    }

    public function test_duplicate_sku_is_rejected(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'sku' => 'PRD-TEST-DUPE',
            'name' => 'Keyboard A',
            'purchase_price' => 50000,
            'selling_price' => 75000,
            'stock' => 5,
            'minimum_stock' => 1,
        ]);

        $response = $this->actingAs($this->admin)->post('/products', [
            'sku' => 'PRD-TEST-DUPE', // Duplicate SKU
            'name' => 'Keyboard B',
            'category_id' => $this->category->id,
            'purchase_price' => 60000,
            'selling_price' => 90000,
            'stock' => 5,
            'minimum_stock' => 1,
        ]);

        $response->assertSessionHasErrors('sku');
    }

    public function test_negative_price_or_stock_is_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post('/products', [
            'sku' => 'PRD-TEST-NEG',
            'name' => 'Barang Negatif',
            'category_id' => $this->category->id,
            'purchase_price' => -5000, // Negative!
            'selling_price' => 10000,
            'stock' => -2, // Negative!
            'minimum_stock' => -1, // Negative!
        ]);

        $response->assertSessionHasErrors(['purchase_price', 'stock', 'minimum_stock']);
    }
}
