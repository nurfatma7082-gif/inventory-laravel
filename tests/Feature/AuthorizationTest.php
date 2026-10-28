<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $staff;
    protected User $admin;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create(['name' => 'Elektronik']);
        $this->product = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-AUTH-001',
            'name' => 'Produk Tes',
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'stock' => 10,
            'minimum_stock' => 2,
        ]);
    }

    public function test_staff_cannot_access_user_management(): void
    {
        $response = $this->actingAs($this->staff)->get('/users');
        $response->assertStatus(403);
    }

    public function test_staff_cannot_create_categories(): void
    {
        $response = $this->actingAs($this->staff)->post('/categories', [
            'name' => 'Kategori Ilegal',
        ]);
        $response->assertStatus(403);
    }

    public function test_staff_cannot_delete_products(): void
    {
        $response = $this->actingAs($this->staff)->delete("/products/{$this->product->id}");
        $response->assertStatus(403);
    }

    public function test_staff_can_view_products_and_create_sales(): void
    {
        $response = $this->actingAs($this->staff)->get('/products');
        $response->assertStatus(200);

        $salesPage = $this->actingAs($this->staff)->get('/sales/create');
        $salesPage->assertStatus(200);
    }
}
