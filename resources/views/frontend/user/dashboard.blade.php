@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('frontend.includes.banner', [
    'title' => 'Account Details'
])

<section class="contentContainer smallContainer">
    <div class="container">

        <div class="row">

            {{-- Sidebar --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            {{-- Account Content --}}
            <div class="col-lg-9 col-md-8">

                <style>

                    .contactForm input[type="radio"] {
                        height: 15px !important;
                    }

                    .accountInfo .list {
                        padding: 12px 0;
                    }

                    .accountInfo .list label {
                        font-weight: 500;
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
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </p>


                        <p>
                            You have used
                            <strong>{{ $image_storage_used ?? 0 }}MB</strong>
                            of your
                            <strong>{{ $image_storage_limit ?? 0 }}MB</strong>
                            image gallery space.
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
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
                                        <div class="col-md-6 col-lg-6">
                                            <label>First Name</label>
                                            <div>{{ $user->name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>Last Name</label>
                                            <div class="">
                                                {{ $user->name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="list borderBottom">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <label>Email</label>
                                            <div class="">
                                                {{ $user->email ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>Company/Organization</label>
                                            <div class="">
                                                {{ $user->company_name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="list borderBottom">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <label>Phone Number</label>
                                            <div class="">
                                                {{ $user->company_phone ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>Fax Number</label>
                                            <div class="">
                                                {{ $user->company_fax ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="list borderBottom">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <label>Address</label>
                                            <div class="">
                                                {{ $user->company_address ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>City/Town</label>
                                            <div class="">
                                                {{ $user->city ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="list borderBottom">
                                    <div class="row">
                                         <div class="col-md-6 col-lg-6">
                                            <label>State/Province</label>
                                            <div class="">
                                                {{ $user->state ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>Country</label>
                                            <div class="">
                                                {{ $user->country ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="list borderBottom">
                                    <div class="row">
                                         <div class="col-md-6 col-lg-6">
                                            <label>Zip/Postal Code</label>
                                            <div class="">
                                                {{ $user->zip ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label>Package Type</label>
                                            <div class="">
                                                {{ $user->package_type ?? 'Free' }}
                                            </div>
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