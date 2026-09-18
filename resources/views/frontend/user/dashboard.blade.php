@extends('frontend.layouts.app')

@section('title', 'Dashboard')

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

                <style>
                    .activeclass {
                        background-color: #e62d29;
                        color: #fff !important;
                    }

                    .contactForm input[type="radio"] {
                        height: 15px !important;
                    }

                    .accountInfo .list {
                        padding: 12px 0;
                    }

                    .accountInfo .list strong {
                        display: block;
                    }
                </style>

                <div class="acoountRightSection">

                    {{-- Heading --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="borderBottom">
                                <h2>My Account</h2>

                                @if(session('success'))
                                    <p class="text-center text-success">
                                        {{ session('success') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Package Information --}}
                    <div class="mt-4">

                        <p>
                            You have the
                            <strong>
                                {{ $user->package_type ?? 'Free' }}
                            </strong>
                            package.
                        </p>

                        <p>
                            You have
                            <strong>{{ $only_mail ?? 0 }}</strong>
                            contacts remaining to upload.

                            <a href="{{ route('pricing') }}" class="linkButton">
                                Add more emails?
                            </a>
                        </p>

                        <p>
                            You have used
                            <strong>{{ $image_usage_percent ?? 0 }}%</strong>
                            of your
                            <strong>{{ $image_storage_limit ?? 0 }}MB</strong>
                            image gallery space.
                        </p>

                        <p>
                            You have used
                            <strong>{{ $image_storage_used ?? 0 }}MB</strong>
                            of your
                            <strong>{{ $image_storage_limit ?? 0 }}MB</strong>
                            image gallery space.

                            <a href="#" class="linkButton">
                                Upload images?
                            </a>
                        </p>

                    </div>

                    {{-- Account Information --}}
                    <div class="accountInfo mt-4">

                        {{-- Name --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Name</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Email</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->email ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Company --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Company/Organization</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->company_name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Address</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->company_address ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Phone Number</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->company_phone ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Fax --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Fax Number</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->company_fax ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- City --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>City/Town</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->city ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- State --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>State/Province</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->state ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Country --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Country</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->country ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Zip --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Zip/Postal Code</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->zip ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Package --}}
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <strong>Package Type</strong>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-7">
                                    {{ $user->package_type ?? 'Free' }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection