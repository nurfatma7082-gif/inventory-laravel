<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Demo
        $admin = User::firstOrCreate(
            ['email' => 'admin@inventory.com'],
            [
                'name' => 'Administrator Toko',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@inventory.com'],
            [
                'name' => 'Staff Operasional',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // 2. Kategori Master
        $catElectronics = Category::firstOrCreate(['name' => 'Elektronik & Gadget'], ['description' => 'Aksesoris komputer dan gadget']);
        $catAtk = Category::firstOrCreate(['name' => 'Alat Tulis Kantor'], ['description' => 'Kebutuhan tulis, kertas, dan administrasi kantor']);
        $catTools = Category::firstOrCreate(['name' => 'Perkakas & Hardware'], ['description' => 'Alat pertukangan dan perbaikan ringan']);
        $catFood = Category::firstOrCreate(['name' => 'Makanan & Minuman'], ['description' => 'Produk konsumsi siap saji dan minuman']);

        // 3. Supplier Master
        $supp1 = Supplier::firstOrCreate(
            ['name' => 'PT Sumber Elektronik Abadi'],
            [
                'phone' => '081234567890',
                'email' => 'info@sumberelektronik.co.id',
                'address' => 'Jl. Mangga Dua Raya No. 45, Jakarta Pusat',
            ]
        );

        $supp2 = Supplier::firstOrCreate(
            ['name' => 'CV ATK Makmur Sejahtera'],
            [
                'phone' => '082198765432',
                'email' => 'sales@atkmakmur.com',
                'address' => 'Jl. Sudirman No. 12, Bandung',
            ]
        );

        $supp3 = Supplier::firstOrCreate(
            ['name' => 'Distributor Sinar Terang'],
            [
                'phone' => '085712344321',
                'email' => 'kontak@sinarterang.com',
                'address' => 'Jl. Pemuda No. 88, Semarang',
            ]
        );

        // 4. Produk Master (Ada yang stok cukup dan stok menipis untuk uji dashboard alert)
        $products = [
            [
                'category_id' => $catElectronics->id,
                'sku' => 'PRD-ELK-001',
                'name' => 'Mouse Wireless Logitech M170',
                'purchase_price' => 120000,
                'selling_price' => 165000,
                'stock' => 25,
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catElectronics->id,
                'sku' => 'PRD-ELK-002',
                'name' => 'Keyboard Mechanical RGB TKL',
                'purchase_price' => 350000,
                'selling_price' => 480000,
                'stock' => 15,
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catElectronics->id,
                'sku' => 'PRD-ELK-003',
                'name' => 'Flashdisk Sandisk 64GB USB 3.0',
                'purchase_price' => 65000,
                'selling_price' => 95000,
                'stock' => 35,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $catElectronics->id,
                'sku' => 'PRD-ELK-004',
                'name' => 'Headset Gaming Rexer Pro',
                'purchase_price' => 190000,
                'selling_price' => 265000,
                'stock' => 3, // Low stock alert
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catAtk->id,
                'sku' => 'PRD-ATK-001',
                'name' => 'Kertas HVS A4 PaperOne 80gr 1 Rim',
                'purchase_price' => 48000,
                'selling_price' => 60000,
                'stock' => 50,
                'minimum_stock' => 15,
            ],
            [
                'category_id' => $catAtk->id,
                'sku' => 'PRD-ATK-002',
                'name' => 'Pulpen Gel Joyko 0.5mm (Pak isi 12)',
                'purchase_price' => 24000,
                'selling_price' => 35000,
                'stock' => 2, // Low stock alert
                'minimum_stock' => 8,
            ],
            [
                'category_id' => $catAtk->id,
                'sku' => 'PRD-ATK-003',
                'name' => 'Binder Clip No. 107 Joyko',
                'purchase_price' => 12000,
                'selling_price' => 18000,
                'stock' => 30,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $catTools->id,
                'sku' => 'PRD-PRK-001',
                'name' => 'Obeng Set Presisi 32-in-1',
                'purchase_price' => 45000,
                'selling_price' => 70000,
                'stock' => 12,
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catTools->id,
                'sku' => 'PRD-PRK-002',
                'name' => 'Tang Kombinasi 8 Inch Chrome',
                'purchase_price' => 38000,
                'selling_price' => 55000,
                'stock' => 1, // Low stock alert
                'minimum_stock' => 4,
            ],
            [
                'category_id' => $catFood->id,
                'sku' => 'PRD-FNB-001',
                'name' => 'Kopi Kapal Api Spesial Mix 1 Renceng',
                'purchase_price' => 15000,
                'selling_price' => 20000,
                'stock' => 60,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $catFood->id,
                'sku' => 'PRD-FNB-002',
                'name' => 'Teh Celup Sariwangi Kotak 25s',
                'purchase_price' => 7500,
                'selling_price' => 11000,
                'stock' => 45,
                'minimum_stock' => 10,
            ],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(['sku' => $p['sku']], $p);
        }

        // 5. Data Transaksi Demo Pembelian Awal (Purchase)
        $p1 = Product::where('sku', 'PRD-ELK-001')->first();
        $p2 = Product::where('sku', 'PRD-ELK-002')->first();

        $purchase = Purchase::firstOrCreate(
            ['purchase_number' => 'PO-' . date('Ymd') . '-0001'],
            [
                'supplier_id' => $supp1->id,
                'user_id' => $admin->id,
                'total' => (10 * $p1->purchase_price) + (5 * $p2->purchase_price),
                'status' => 'completed',
                'purchased_at' => now()->subDays(1),
                'notes' => 'Pengadaan stok awal cabang pusat',
            ]
        );

        PurchaseItem::firstOrCreate(
            ['purchase_id' => $purchase->id, 'product_id' => $p1->id],
            [
                'quantity' => 10,
                'unit_cost' => $p1->purchase_price,
                'subtotal' => 10 * $p1->purchase_price,
            ]
        );

        PurchaseItem::firstOrCreate(
            ['purchase_id' => $purchase->id, 'product_id' => $p2->id],
            [
                'quantity' => 5,
                'unit_cost' => $p2->purchase_price,
                'subtotal' => 5 * $p2->purchase_price,
            ]
        );

        // 6. Data Transaksi Demo Penjualan Awal (Sale)
        $sale = Sale::firstOrCreate(
            ['sale_number' => 'INV-' . date('Ymd') . '-0001'],
            [
                'user_id' => $staff->id,
                'total' => (2 * $p1->selling_price) + (1 * $p2->selling_price),
                'status' => 'completed',
                'sold_at' => now(),
                'notes' => 'Penjualan retail langsung di kasir',
            ]
        );

        SaleItem::firstOrCreate(
            ['sale_id' => $sale->id, 'product_id' => $p1->id],
            [
                'quantity' => 2,
                'unit_price' => $p1->selling_price,
                'subtotal' => 2 * $p1->selling_price,
            ]
        );

        SaleItem::firstOrCreate(
            ['sale_id' => $sale->id, 'product_id' => $p2->id],
            [
                'quantity' => 1,
                'unit_price' => $p2->selling_price,
                'subtotal' => 1 * $p2->selling_price,
            ]
        );
    }
}
