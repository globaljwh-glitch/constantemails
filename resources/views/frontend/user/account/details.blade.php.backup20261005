@extends('frontend.layouts.app')

@section('title', 'Update Profile')

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

            {{-- Account Content --}}
            <div class="col-lg-9 col-md-8">

<div class="acoountRightSection">

    {{-- Header --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Edit your Account Details</h2>

                @if(session('success'))
                    <p class="text-center text-success">
                        {{ session('success') }}
                    </p>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
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


    <div class="accountInfo">

        {{-- Login Information --}}
        <div class="borderBottom">

            <div class="row">
                <div class="col-lg-12">
                    <h4 class="text-orange">Login Information</h4>

                    <p>
                        Your email address and username are like an "ID" card
                        in our system. Your username cannot be changed.
                        If you need to change your email address, please contact us.
                    </p>
                </div>
            </div>

            <div class="list borderBottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        <strong>Username</strong>
                    </div>

                    <div class="col-lg-9 col-md-8 col-sm-7">
                        {{ $user->username ?? $user->name ?? '-' }}
                    </div>
                </div>
            </div>

            <p class="small02">
                This is your username. You will always need it to log in,
                so make sure you remember it.
            </p>

            <div class="list borderBottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        <strong>E-mail</strong>
                    </div>

                    <div class="col-lg-9 col-md-8 col-sm-7">
                        {{ $user->email ?? '-' }}
                    </div>
                </div>
            </div>

            <p class="small02">
                This is your primary email address. Alerts, messages and
                notifications will be sent to this email address.
            </p>

        </div>


        {{-- Update Form --}}
        <form
            method="POST"
            action="{{ route('user.account.update') }}"
            class="contactForm"
        >

            @csrf
            @method('PUT')


            {{-- Contact Information --}}
            <div class="contactForm borderBottom">

                <div class="row">

                    <div class="col-lg-12">
                        <h4 class="text-orange">Contact Information</h4>
                        <p>Edit your Contact Information</p>
                    </div>


                    {{-- First Name --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Name"
                        >
                    </div>


                    {{-- Last Name --}}
                    <!-- <div class="col-md-6 col-lg-6">
                        <label>Last Name</label>

                        <input
                            type="text"
                            name="last_name"
                            value="{{ old('last_name', $user->last_name) }}"
                            placeholder="Last Name"
                        >
                    </div> -->


                    {{-- Company --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Company</label>

                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name', $user->company_name) }}"
                            placeholder="Company (Optional)"
                        >
                    </div>


                    {{-- Address --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Address</label>

                        <input
                            type="text"
                            name="company_address"
                            value="{{ old('company_address', $user->company_address) }}"
                            placeholder="Address"
                        >
                    </div>


                    {{-- Phone --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Phone</label>

                        <input
                            type="text"
                            name="company_phone"
                            value="{{ old('company_phone', $user->company_phone) }}"
                            placeholder="Phone"
                        >
                    </div>


                    {{-- Fax --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Fax</label>

                        <input
                            type="text"
                            name="company_fax"
                            value="{{ old('company_fax', $user->company_fax) }}"
                            placeholder="Fax"
                        >
                    </div>


                    {{-- City --}}
                    <div class="col-md-6 col-lg-6">
                        <label>City/Town</label>

                        <input
                            type="text"
                            name="city"
                            value="{{ old('city', $user->city) }}"
                            placeholder="City"
                        >
                    </div>


                    {{-- State --}}
                    <div class="col-md-6 col-lg-6">
                        <label>State/Province</label>

                        <input
                            type="text"
                            name="state"
                            value="{{ old('state', $user->state) }}"
                            placeholder="State"
                        >
                    </div>


                    {{-- Country --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Country</label>

                        <input
                            type="text"
                            name="country"
                            value="{{ old('country', $user->country) }}"
                            placeholder="Country"
                        >
                    </div>


                    {{-- Zip --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Zip/Postal Code</label>

                        <input
                            type="text"
                            name="zip"
                            value="{{ old('zip', $user->zip) }}"
                            placeholder="Zip"
                        >
                    </div>

                </div>

            </div>


            {{-- Billing Information --}}
            <div class="contactForm borderBottom">

                <div class="row">

                    <div class="col-lg-12">
                        <h4 class="text-orange">Billing Information</h4>

                        <p>
                            Edit this information if you are upgrading your
                            package or adding a credit card. If you are using
                            our trial membership, you may leave this blank.
                        </p>
                    </div>


                    {{-- Billing First Name --}}
                    <div class="col-md-6 col-lg-6">
                        <label>First Name</label>

                        <input
                            type="text"
                            name="billing_first_name"
                            value="{{ old('billing_first_name', $user->billing_first_name) }}"
                            placeholder="First Name"
                        >
                    </div>


                    {{-- Billing Last Name --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Last Name</label>

                        <input
                            type="text"
                            name="billing_last_name"
                            value="{{ old('billing_last_name', $user->billing_last_name) }}"
                            placeholder="Last Name"
                        >
                    </div>


                    {{-- Billing Address --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Billing Address</label>

                        <input
                            type="text"
                            name="billing_address"
                            value="{{ old('billing_address', $user->billing_address) }}"
                            placeholder="Address"
                        >
                    </div>


                    {{-- Billing City --}}
                    <div class="col-md-6 col-lg-6">
                        <label>City/Town</label>

                        <input
                            type="text"
                            name="billing_city"
                            value="{{ old('billing_city', $user->billing_city) }}"
                            placeholder="City"
                        >
                    </div>


                    {{-- Billing State --}}
                    <div class="col-md-6 col-lg-6">
                        <label>State/Province</label>

                        <input
                            type="text"
                            name="billing_state"
                            value="{{ old('billing_state', $user->billing_state) }}"
                            placeholder="State"
                        >
                    </div>


                    {{-- Billing Country --}}
                    <div class="col-md-6 col-lg-6">
                        <label>Country</label>

                        <input
                            type="text"
                            name="billing_country"
                            value="{{ old('billing_country', $user->billing_country) }}"
                            placeholder="Country"
                        >
                    </div>

                </div>

            </div>


            {{-- Submit --}}
            <div class="contactForm">

                <div class="row">

                    <div class="col-md-12">

                        <button
                            type="submit"
                            class="submitButton mb-0"
                        >
                            Update
                        </button>

                    </div>

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
