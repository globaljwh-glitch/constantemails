@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')

{{-- ================================
     Contact Banner
================================ --}}
<section class="homeBanner innerBanner">

    <div class="container">

        <div class="row">

            <div class="col-lg-10 marginAuto">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <h1>Contact Us</h1>

                        <p>
                            Here at Constant Emails, your questions are our first priority!
                            Skilled marketers are standing by ready to assist you with your
                            business questions and concerns. Our support team will get back
                            to you as soon as your inquiry reaches us!
                        </p>

                        <div class="header-button-container">

                            <a
                                href="{{ route('register') }}"
                                class="custom-btn1 orangeBg"
                            >
                                Try For Free
                            </a>

                            <a
                                href="{{ route('pricing') }}"
                                class="custom-btn1 transparent-btn"
                            >
                                Pricing Plans
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ================================
     Contact Section
================================ --}}
<section class="contentContainer">

    <div class="container">


        {{-- =================================
             Success Message
        ================================= --}}
        @if(session('success'))

            <div class="alert alert-success contactAlert">
                {{ session('success') }}
            </div>

        @endif


        {{-- =================================
             Warning Message
        ================================= --}}
        @if(session('warning'))

            <div class="alert alert-warning contactAlert">
                {{ session('warning') }}
            </div>

        @endif


        {{-- =================================
             General Error Message
        ================================= --}}
        @if(session('error'))

            <div class="alert alert-danger contactAlert">
                {{ session('error') }}
            </div>

        @endif


        {{-- =================================
             Validation Errors
        ================================= --}}
        @if($errors->any())

            <div class="alert alert-danger contactAlert">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =================================
             Intro
        ================================= --}}
        <div class="row">

            <div class="col-lg-12">

                <div class="contactThankYou">

                    <strong>
                        Thank you for contacting us!
                    </strong>

                    <p>
                        Your questions and concerns are our first priority.
                    </p>

                    <p>
                        We will get back to you promptly regarding your message.
                        We try our best to answer most messages within
                        <strong>24 to 48 hours.</strong>
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================
             Contact Form
        ================================= --}}
        <div class="contactForm">

            <div class="row">


                {{-- =================================
                     Form
                ================================= --}}
                <div class="col-md-8 col-lg-8">

                    <form
                        method="POST"
                        action="{{ route('contact.store') }}"
                        class="contactUsForm"
                    >

                        @csrf


                        <div class="row">


                            {{-- First Name --}}
                            <div class="col-md-6 col-lg-6 mb-3">

                                <input
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    placeholder="First Name"
                                    maxlength="100"
                                    autocomplete="given-name"
                                    required
                                >

                                @error('first_name')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Last Name --}}
                            <div class="col-md-6 col-lg-6 mb-3">

                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    placeholder="Last Name"
                                    maxlength="100"
                                    autocomplete="family-name"
                                >

                                @error('last_name')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6 col-lg-6 mb-3">

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Email"
                                    maxlength="255"
                                    autocomplete="email"
                                    required
                                >

                                @error('email')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Organization --}}
                            <div class="col-md-6 col-lg-6 mb-3">

                                <input
                                    type="text"
                                    name="organization"
                                    value="{{ old('organization') }}"
                                    placeholder="Organization"
                                    maxlength="255"
                                    autocomplete="organization"
                                >

                                @error('organization')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Phone --}}
                            <div class="col-md-6 col-lg-6 mb-3">

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Phone Number"
                                    maxlength="50"
                                    autocomplete="tel"
                                >

                                @error('phone')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Message --}}
                            <div class="col-md-12 col-lg-12 mb-3">

                                <textarea
                                    name="comments"
                                    placeholder="Message"
                                    maxlength="5000"
                                    required
                                >{{ old('comments') }}</textarea>

                                @error('comments')

                                    <span class="contactFieldError">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Submit --}}
                            <div class="col-md-12 col-lg-12">

                                <button
                                    type="submit"
                                    class="submitButton mb-0"
                                >
                                    Submit
                                </button>

                            </div>

                        </div>

                    </form>

                </div>


                {{-- =================================
                     Google Map
                ================================= --}}
                <div class="col-md-4 col-lg-4">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d929791.0698853646!2d-75.1038233558096!3d40.050138907904106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c0fb959e00409f%3A0x2cd27b07f83f6d8d!2sNew%20Jersey%2C%20USA!5e0!3m2!1sen!2sin!4v1579256760371!5m2!1sen!2sin"
                        width="100%"
                        height="455"
                        style="border:0;"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection


@push('styles')

<style>

    .contactAlert {
        margin-bottom: 30px;
    }

    .contactThankYou {
        text-align: center;
        margin-bottom: 35px;
        line-height: 1.7;
    }

    .contactThankYou > strong {
        display: block;
        margin-bottom: 15px;
        font-size: 18px;
        color: #ed2929;
    }

    .contactThankYou p {
        margin: 5px 0;
    }

    .contactUsForm input,
    .contactUsForm textarea {
        width: 100%;
    }

    .contactUsForm textarea {
        min-height: 160px;
        resize: vertical;
    }

    .contactFieldError {
        display: block;
        margin-top: 5px;
        color: #dc3545;
        font-size: 13px;
    }

    .contactUsForm .submitButton {
        border: 0;
        cursor: pointer;
    }

    @media (max-width: 767px) {

        .contactThankYou {
            margin-bottom: 25px;
        }

    }

</style>

@endpush