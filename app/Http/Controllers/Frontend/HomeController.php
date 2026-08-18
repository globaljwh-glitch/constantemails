<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationPackage;

class HomeController extends Controller
{
    public function index()
    {
        // if (auth()->check()) {
        //     return redirect()->route('admin.dashboard');
        // }

        return view('frontend.home.index');
    }

    public function pricing()
    {
        $packages = RegistrationPackage::where('status', 'Active')
            ->orderBy('package_price')
            ->get();

        return view('frontend.pages.pricing', compact('packages'));
    }

    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    public function terms()
    {
        return view('frontend.pages.terms');
    }

    public function antispam()
    {
        return view('frontend.pages.antispam');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function resource()
    {
        return view('frontend.pages.resource');
    }

    public function feature()
    {
        return view('frontend.pages.features');
    }

}
