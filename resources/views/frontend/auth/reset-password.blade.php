@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@section('content')

<section class="contentContainer">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-6">

                <h1>Reset Password</h1>

                <p>Enter your new password below.</p>

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">

                    @csrf

                    {{-- Reset Token --}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Email Address</label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ request()->email }}"
                            required
                        >
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">New Password</label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="form-group mt-3">
                        <label for="password_confirmation">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="custom-btn1 orangeBg mt-3">
                        Reset Password
                    </button>

                </form>

            </div>

        </div>
    </div>
</section>

@endsection