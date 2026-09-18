@extends('frontend.layouts.app')

@section('title', 'Change Password')

@section('content')

@include('frontend.includes.banner', [
    'title' => 'Account Details'
])

<section class="contentContainer">
    <div class="container">

        <div class="row">

            {{-- Sidebar --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            {{-- Content --}}
            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- Heading --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="borderBottom">
                                <h2>Update your Account Password</h2>

                                @if(session('success'))
                                    <p class="text-center text-success">
                                        {{ session('success') }}
                                    </p>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="mt-4">
                        Enter your new password here, make sure it is at least
                        <strong>6 characters long</strong>.
                        Changes you make will be instant.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('user.account.password.update') }}"
                    >
                        @csrf
                        @method('PUT')

                        <div class="accountInfo">

                            <div class="contactForm">

                                {{-- Current Password --}}
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <strong>Current Password:</strong>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input
                                            type="password"
                                            name="current_password"
                                            id="current_password"
                                            maxlength="255"
                                            autocomplete="current-password"
                                            required
                                        >
                                    </div>
                                </div>

                                {{-- New Password --}}
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <strong>New Password:</strong>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            maxlength="255"
                                            autocomplete="new-password"
                                            required
                                        >
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <strong>Confirm New Password:</strong>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            maxlength="255"
                                            autocomplete="new-password"
                                            required
                                        >
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="row mt-4">
                                    <div class="col-md-12 col-lg-12">

                                        <button
                                            type="submit"
                                            class="submitButton mb-0"
                                        >
                                            Update
                                        </button>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection