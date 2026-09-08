<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Enquiry;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalEnquiries = Enquiry::count();
        $newEnquiries = Enquiry::where('status', 'new')->count();
        
        $categoriesCount = [
            'Cutting Tools' => Product::where('category_id', 1)->count(),
            'Measuring Equipment' => Product::where('category_id', 2)->count(),
            'Standard Parts' => Product::where('category_id', 3)->count(),
            'Aerospace Parts' => Product::where('category_id', 4)->count(),
            'Raw Materials' => Product::where('category_id', 5)->count(),
        ];

        $recentProducts = Product::orderBy('created_at', 'desc')->limit(6)->get();
        $recentEnquiries = Enquiry::orderBy('created_at', 'desc')->limit(6)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalEnquiries',
            'newEnquiries',
            'categoriesCount',
            'recentProducts',
            'recentEnquiries'
        ));
    }
}
