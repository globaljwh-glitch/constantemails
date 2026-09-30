@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@section('content')

<section class="contentContainer">
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
</section>

@endsection