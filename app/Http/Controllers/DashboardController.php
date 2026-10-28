<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Purchase;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalSuppliers = Supplier::count();
        $totalCategories = Category::count();
        
        $totalSalesCount = Sale::where('status', 'completed')->count();
        $salesToday = Sale::where('status', 'completed')->whereDate('sold_at', today())->sum('total');
        $salesThisMonth = Sale::where('status', 'completed')
            ->whereMonth('sold_at', now()->month)
            ->whereYear('sold_at', now()->year)
            ->sum('total');

        $lowStockCount = Product::lowStock()->count();
        $lowStockProducts = Product::with('category')
            ->lowStock()
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $recentSales = Sale::with('user')
            ->latest('sold_at')
            ->take(5)
            ->get();

        $recentPurchases = Purchase::with(['supplier', 'user'])
            ->latest('purchased_at')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'totalSuppliers',
            'totalCategories',
            'totalSalesCount',
            'salesToday',
            'salesThisMonth',
            'lowStockCount',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}
