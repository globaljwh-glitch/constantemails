@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('frontend.includes.banner', [
    'title' => 'Accounts Details'
])

<section class="contentContainer">
    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            <div class="col-lg-9 col-md-8">

                <style>
                    .activeclass {
                        background-color: #e62d29;
                        color: #fff !important;
                    }

                    .contactForm input[type="radio"] {
                        height: 15px !important;
                    }
                </style>

                <div class="acoountRightSection">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="borderBottom">
                                <h2>My Account</h2>
                                <p class="text-center text-danger">
                                    The changes you made have been successfully saved!
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4">You have the unlimited package!</p>

                    <p class="mt-4">
                        You have {{ $only_mail ?? 0 }} contacts remaining to upload.
                        <a href="{{ route('pricing') }}" class="linkButton">
                            Add more emails?
                        </a>
                    </p>

                    <p>
                        You have used 10% of your 8000MB image gallery space.
                    </p>

                    <p>
                        You have used 0MB of your 5MB image gallery space.
                        <a href="#" class="linkButton">
                            Upload images?
                        </a>
                    </p>

                    <div class="accountInfo">
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Name</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">First_name last_name</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Company/Organization:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">company_name</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Address:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Phone Number:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Fax Number:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>City/Town:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>State/Providence:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Country:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Zip/Postal Code:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                        <div class="list borderBottom">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Package Type:</strong></div>
                                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection