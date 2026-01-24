<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'users' => \App\Models\User::count(),
            'members' => \App\Models\Member::count(),
            'posts' => \App\Models\Post::count(),
            'portfolios' => \App\Models\Portfolio::count(),
            'services' => \App\Models\Service::count(),
            'orders' => \App\Models\Order::count(),
            'products' => \App\Models\Product::count(),
            'customers' => \App\Models\Customer::count(),
        ];

        $totalRevenue = \App\Models\Order::all()->sum(function ($order) {
            return (float) $order->total;
        });

        // Last 6 months sales data
        $driver = \DB::getDriverName();
        $dateField = $driver === 'sqlite' ? "strftime('%Y-%m', created_at)" : "DATE_FORMAT(created_at, '%Y-%m')";

        $monthlySales = \App\Models\Order::selectRaw("$dateField as month, SUM(CAST(total AS DECIMAL(10,2))) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Order distribution by type
        $orderTypes = \App\Models\Order::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->get();

        $recentOrders = \App\Models\Order::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('counts', 'totalRevenue', 'monthlySales', 'orderTypes', 'recentOrders'));
    }
}
