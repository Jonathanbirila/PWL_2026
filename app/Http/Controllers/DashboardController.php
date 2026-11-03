<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('subtotal');
        $totalCustomers = User::where('role', 'pembeli')->count();

        $recentTransactions = Transaction::with(['user', 'details.product'])
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::with('supplier')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'totalTransactions',
            'totalRevenue',
            'totalCustomers',
            'recentTransactions',
            'recentProducts'
        ));
    }
}

