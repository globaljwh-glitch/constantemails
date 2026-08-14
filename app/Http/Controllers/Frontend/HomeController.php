<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationPackage;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('frontend.home.index');
    }

    public function pricing()
    {
        $packages = RegistrationPackage::where('status', 'Active')
            ->orderBy('package_price')
            ->get();

        return view('frontend.pages.pricing', compact('packages'));
    }
}
