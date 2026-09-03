<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('frontend.user.dashboard');
    }

    public function profile()
    {
        //
    }

    public function updateProfile()
    {
        //
    }

    public function billing()
    {
        //
    }

    public function subscription()
    {
        //
    }
}