@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')

<section class="contentContainer loginForm">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-6 col-xl-5">

                <h2>Login to Account</h2>

                <p>Enter your email and password to login to your account.</p>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="contactForm pt-2">

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="row">

                            {{-- Email --}}
                            <div class="col-lg-12 mb-3">
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Email Address"
                                    class="@error('email') is-invalid @enderror">

                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-lg-12 mb-3">
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    class="@error('password') is-invalid @enderror">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Remember --}}
                            <div class="col-lg-12 mb-3">

                                <input
                                    type="checkbox"
                                    class="checkbox"
                                    id="remember"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label for="remember">
                                    Remember Me
                                </label>

                            </div>

                            {{-- Login Button --}}
                            <div class="col-sm-4">
                                <button
                                    type="submit"
                                    class="submitButton mb-0">
                                    Login
                                </button>
                            </div>

                            {{-- Forgot Password --}}
                            <div class="col-sm-8">
                                <div class="forgot">
                                    <a href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>

                            {{-- Register --}}
                            <div class="col-lg-12 mt-3">
                                <div class="createAccount text-left">
                                    Need a Constant Email account?
                                    <a href="{{ route('register') }}">
                                        Create an Account
                                    </a>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <div class="col-md-12 col-lg-6 col-xl-7">
                <div class="imageThumb text-right">
                    <img
                        src="{{ asset('frontend/images/login-thumb.jpg') }}"
                        alt="Login"
                        class="img-fluid">
                </div>
            </div>

        </div>
    </div>
</section>

@endsection