<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationPackage;
use App\Models\TemplateCategory;

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
            ->where('access_level', 'user')
            ->orderBy('package_price', 'asc')
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

    public function template()
    {
        $categories = TemplateCategory::where('status', 'Active')
            ->with([
                'templates' => function ($query) {
                    $query->where('status', 'Active')
                        ->orderBy('id', 'desc');
                }
            ])
            ->orderBy('id')
            ->get();

        return view('frontend.pages.our_templates', compact('categories'));
    }

    public function managedAccounts()
    {
        return view('frontend.pages.managed-accounts');
    }

}
