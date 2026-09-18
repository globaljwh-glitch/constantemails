@extends('frontend.layouts.app')

@section('title', 'Upgrade Package')

@section('content')

    @include('frontend.includes.banner', ['title' => 'Upgrade Package'])

    <section class="contentContainer">
        <div class="container">
            <div class="row">

                {{-- Sidebar --}}
                <div class="col-lg-3 col-md-4">
                    @include('frontend.includes.sidebar')
                </div>

                {{-- Right Content --}}
                <div class="col-lg-9 col-md-8">

                    <div class="acoountRightSection">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="borderBottom">
                                    <h2>Upgrade Package</h2>
                                </div>
                            </div>
                        </div>

                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="mt-4">
                            <strong>My Package Details</strong>
                        </p>

                        <p>
                            Please pick the pricing package of your choice.
                            The address information you enter should match the
                            information on your credit card.
                        </p>

                        <p>
                            If you would like a package of more than 100,000 emails,
                            please go to our
                            <a href="{{ url('/managed-accounts') }}" target="_blank">
                                Managed Accounts
                            </a>
                            page for more information.
                        </p>

                        <form
                            method="POST"
                            action="{{ route('user.account.upgrade.store') }}"
                            class="upgradePackageForm"
                        >
                            @csrf

                            <div class="accountInfo">
                                <div class="contactForm">

                                    {{-- Package --}}
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <strong>Package Name:</strong>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <select
                                                name="package_id"
                                                class="form_input"
                                                required
                                            >
                                                <option value="">
                                                    Select Package
                                                </option>

                                                @foreach($packages as $package)
                                                    <option
                                                        value="{{ $package->id }}"
                                                        {{ old('package_id') == $package->id ? 'selected' : '' }}
                                                    >
                                                        {{ $package->package_name }}
                                                        - ${{ number_format($package->package_price, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <p class="mt-1">
                                                <small>
                                                    Choose a pricing package from the dropdown box.
                                                </small>
                                            </p>

                                        </div>
                                    </div>

                                    {{-- Card Type --}}
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <strong>* Card Type:</strong>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <select
                                                name="creditCardType"
                                                class="form_input"
                                                required
                                            >
                                                <option value="Visa"
                                                    {{ old('creditCardType', 'Visa') == 'Visa' ? 'selected' : '' }}>
                                                    Visa
                                                </option>

                                                <option value="MasterCard"
                                                    {{ old('creditCardType') == 'MasterCard' ? 'selected' : '' }}>
                                                    MasterCard
                                                </option>

                                                <option value="Discover"
                                                    {{ old('creditCardType') == 'Discover' ? 'selected' : '' }}>
                                                    Discover
                                                </option>

                                                <option value="Amex"
                                                    {{ old('creditCardType') == 'Amex' ? 'selected' : '' }}>
                                                    American Express
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    {{-- Credit Card Number --}}
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <strong>* Credit Card Number:</strong>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <input
                                                type="text"
                                                name="bill_ccn"
                                                class="form_input"
                                                maxlength="19"
                                                autocomplete="cc-number"
                                                value="{{ old('bill_ccn') }}"
                                                required
                                            >
                                        </div>
                                    </div>

                                    {{-- Expiration --}}
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <strong>* Expiration Date:</strong>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="row">

                                                <div class="col-6">
                                                    <select
                                                        name="bill_ccexpm"
                                                        id="month1"
                                                        class="form_input"
                                                        required
                                                    >
                                                        <option value="">Month</option>

                                                        @foreach(range(1, 12) as $month)
                                                            <option
                                                                value="{{ $month }}"
                                                                {{ old('bill_ccexpm') == $month ? 'selected' : '' }}
                                                            >
                                                                {{ date('M', mktime(0, 0, 0, $month, 1)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <select
                                                        name="bill_ccexpyr"
                                                        id="dpdYear"
                                                        class="form_input"
                                                        required
                                                    >
                                                        <option value="">Year</option>

                                                        @for($year = now()->year; $year <= now()->year + 15; $year++)
                                                            <option
                                                                value="{{ $year }}"
                                                                {{ old('bill_ccexpyr') == $year ? 'selected' : '' }}
                                                            >
                                                                {{ $year }}
                                                            </option>
                                                        @endfor

                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    {{-- Security Code --}}
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <strong>* Security Code:</strong>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <input
                                                type="text"
                                                name="bill_cccvn"
                                                class="form_input"
                                                maxlength="4"
                                                autocomplete="cc-csc"
                                                value="{{ old('bill_cccvn') }}"
                                                required
                                            >

                                            <a
                                                href="{{ url('/security-code') }}"
                                                target="_blank"
                                                class="ms-2"
                                            >
                                                <small>Where is it?</small>
                                            </a>

                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="row mt-4">
                                        <div class="col-md-12 col-lg-12">

                                            <button
                                                type="submit"
                                                class="submitButton mb-0"
                                            >
                                                Upgrade Package
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