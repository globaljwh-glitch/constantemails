<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationPackage;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Top Widget Stats
        $totalCustomers = User::where('is_admin', 0)->count();
        $newCustomers = User::where('is_admin', 0)->where('created_at', '>=', now()->subDays(7))->count();

        $totalPackages = RegistrationPackage::count();

        // Placeholders for tables you might build later
        $totalSales = 98225; // Replace with: Order::count();
        $totalIncome = 9500000; // Replace with: Order::sum('amount');
        $totalOrders = 24017;

        // Fetch data from DB
        $pageViewsArray = [120, 250, 180, 400, 310, 500, 450]; // Example fetched from DB
        $visitorsArray = [90, 150, 110, 200, 180, 300, 250];  // Example fetched from DB

        $revenue = 80000;
        $profit = 30000;


        // 2. Table Data
        $newPackages = RegistrationPackage::latest()->take(5)->get();

        // 3. Activity Feed (Using latest users as an example)
        $recentActivities = User::latest()->take(4)->get();

        return view('admin.dashboard.index', compact(
            'totalCustomers',
            'newCustomers',
            'totalPackages',
            'totalSales',
            'totalIncome',
            'totalOrders',
            'newPackages',
            'recentActivities',
            'pageViewsArray',
            'visitorsArray',
            'revenue',
            'profit'
        ));
    }

    public function create_package()
    {
        return view('admin.packages.create');
    }




}