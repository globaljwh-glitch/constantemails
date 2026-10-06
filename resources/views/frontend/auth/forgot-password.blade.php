@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@section('content')

<section class="contentContainer loginForm">
    <div class="container">
        <div class="row">

            {{-- Forgot Password Form --}}
            <div class="col-md-12 col-lg-6 col-xl-5">

                <h2>Retrieve Username and Password.</h2>

                <p>
                    Did you forget your Username or Password? No problem!
                </p>

                {{-- Success Message --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="contactForm pt-2">

                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                    >
                        @csrf

                        <div class="row">

                            <div class="col-lg-12">

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter Your Email Address"
                                    class="@error('email') is-invalid @enderror"
                                    required
                                    autofocus
                                >

                                @error('email')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="col-sm-4 col-lg-4">

                                <input
                                    type="submit"
                                    value="Submit"
                                    class="submitButton mb-0"
                                >

                            </div>

                            <div class="col-lg-12">

                                <div class="createAccount text-left">
                                    Need a Constant Email account?
                                    <a href="{{ route('register') }}">
                                        Create an account
                                    </a>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- Right Side Image --}}
            <div class="col-md-12 col-lg-6 col-xl-7">

                <div class="imageThumb text-right">

                    <img
                        src="{{ asset('assets/frontend/images/login-thumb.jpg') }}"
                        alt="Forgot Password"
                        class="img-fluid"
                    >

                </div>

            </div>

        </div>
    </div>
</section>


<!-- <section class="contentContainer">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="loginForm">

                    <h1>Forgot Password</h1>

                    <p>
                        Forgot your password? Enter your email address below
                        and we will send you a link to reset your password.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email Address</label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="Enter your email address"
                                required
                                autofocus
                            >
                        </div>

                        <div class="form-group mt-3">
                            <button
                                type="submit"
                                class="custom-btn1 orangeBg"
                            >
                                Send Password Reset Link
                            </button>
                        </div>

                    </form>

                    <div class="mt-3">
                        <a href="{{ route('login') }}">
                            Back to Login
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section> -->

@endsection