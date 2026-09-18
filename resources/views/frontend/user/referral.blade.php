@extends('frontend.layouts.app')

@section('title', 'Refer a Friend')

@section('content')

<section class="contentContainer">
    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- Page Header --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="borderBottom">
                                <h2>Refer a friend</h2>
                            </div>
                        </div>
                    </div>


                    {{-- Description --}}
                    <p class="mt-4">
                        Email more contacts by referring us to your friends!
                        Our Refer-A-Friend Program was created to reward our
                        customer's loyalty and to help them share our service.

                        The way it works is very simple, just refer us to your
                        friends — make sure they have a valid email address —
                        wait for our confirmation, then get up to 50 free contacts
                        per friend, that's it!

                        <br><br>

                        Fill out the form below to get started.
                    </p>


                    {{-- Referral Form --}}
                    <div class="accountInfo mt-0">

                        <form
                            name="frmReferral"
                            id="frmReferral"
                            action="{{ route('user.referral.store') }}"
                            method="POST"
                        >

                            @csrf

                            <div class="contactForm">


                                {{-- Validation Errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                {{-- Success Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif


                                {{-- Friend's Name --}}
                                <div class="row align-items-center mb-3">

                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <label for="friend_name">
                                            <strong>Friend's name</strong>
                                        </label>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            name="friend_name"
                                            id="friend_name"
                                            maxlength="50"
                                            value="{{ old('friend_name') }}"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                </div>


                                {{-- Friend's Email --}}
                                <div class="row align-items-center mb-3">

                                    <div class="col-lg-3 col-md-6 col-sm-6">

                                        <label for="friend_email">
                                            <strong>Friend's email</strong>
                                        </label>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                        <input
                                            type="email"
                                            name="friend_email"
                                            id="friend_email"
                                            maxlength="100"
                                            value="{{ old('friend_email') }}"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                </div>


                                {{-- Submit --}}
                                <div class="row mt-4">

                                    <div class="col-md-12 col-lg-12">

                                        <button
                                            type="submit"
                                            name="cmdSubmit"
                                            class="submitButton mb-0"
                                        >
                                            Submit
                                        </button>

                                    </div>

                                </div>


                                {{-- Attention Message --}}
                                <div class="mt-4">

                                    <p class="text-left">

                                        <img
                                            src="{{ asset('assets/frontend/images/greenAttention.jpg') }}"
                                            alt="Attention"
                                            style="vertical-align: middle;"
                                        >

                                        Friends' email addresses must be valid.
                                        The system will check for friend's activity
                                        to verify that it is really a person's email
                                        address and not a computer entered address.

                                    </p>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection