@extends('frontend.layouts.app')

@section('title', 'Email Validate')

@section('content')

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

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="borderBottom">

                                <h2>Email Verification</h2>

                            </div>

                        </div>

                    </div>
                    <div class="col-lg-12 accountInfo">
                         <!-- xlsx block -->
                        <h4>General Instructions for multiple emails verification Excel sheet</h4>
                        <p>
                            <strong>Step 1:</strong>
                            It is required that your file follows the header sequence (order)
                            shown in the image below, and has:
                        </p>

                        <p>
                            <b>-</b> <u>NO</u> column headings (e.g., First Name, Last Name, Company, Email, etc...)<br>
                            <b>-</b> Data <strong>ONLY</strong> on the first 6 columns of your spreadsheet.
                        </p>

                        <div style="margin: 15px 0 20px 0;">
                            <img
                                src="{{ asset('assets/frontend/images/headerSequence.png') }}"
                                alt="Microsoft Excel 2007-Present File Format"
                                style="
                                    max-width: 530px;
                                    width: 100%;
                                    height: auto;
                                    display: block;
                                "
                            >
                        </div>
                       
    

                    {{-- Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                        {{-- ========================================================= --}}
                        {{-- FORM --}}
                        {{-- ========================================================= --}}

                        <form
                            action="{{ route('user.post.verification.email') }}"
                            method="POST"
                            enctype="multipart/form-data"  class="validate-email">

                            @csrf

                            <div class="row contactForm align-items-center">

                                {{-- Single Email --}}
                                <div class="col-md-5 mb-3">

                                    <label>
                                        Enter Single Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email') }}"
                                        placeholder="example@gmail.com"
                                    >

                                    <small class="text-muted">
                                        Enter one email address to verify.
                                    </small>

                                </div>
                                {{-- OR Divider --}} 
                                <div class="col-md-2 mb-3 d-flex justify-content-center"> 
                                    <div class="or-divider"> <span>OR</span> 
                                    </div> 
                                </div>

                                {{-- Excel --}}
                                <div class="col-md-5 mb-3">

                                    <label class="form-label fw-bold">
                                        Upload Excel (For multiple emails)
                                    </label>

                                    <input
                                        type="file"
                                        name="email_file"
                                        class="form-control"
                                        accept=".xlsx,.xls,.csv"
                                    >

                                    <small class="text-muted">
                                        Email must be in the 5th column.
                                        No header is required.
                                    </small>

                                </div>

                            </div>


                            <div class="mb-3">

                                <small class="text-danger">
                                    Enter either a single email OR upload an Excel file.
                                </small>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-default orangeBg text-white"
                            >
                                Verify Email(s)
                            </button>

                        </form>


                        {{-- ========================================================= --}}
                        {{-- SINGLE EMAIL RESULT --}}
                        {{-- ========================================================= --}}

                        @if(session('single_result'))

                            @php
                                $result = session('single_result');
                            @endphp

                            <div class="mt-4">

                                <h5>
                                    Verification Result
                                </h5>


                                @if($result['status'] === 'valid')

                                    <div class="alert alert-success">
                                        <strong>Valid Email</strong>
                                    </div>

                                @elseif($result['status'] === 'invalid')

                                    <div class="alert alert-danger">
                                        <strong>Invalid Email</strong>
                                    </div>

                                @elseif($result['status'] === 'catch_all')

                                    <div class="alert alert-warning">
                                        <strong>Catch-All Domain</strong>
                                    </div>

                                @else

                                    <div class="alert alert-warning">
                                        <strong>Unable to Confirm</strong>
                                    </div>

                                @endif


                                <table class="table table-bordered">

                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            {{ $result['email'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <strong>
                                                {{ strtoupper($result['status']) }}
                                            </strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Syntax</th>
                                        <td>
                                            {{ $result['syntax_valid'] ? 'Valid' : 'Invalid' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Domain</th>
                                        <td>
                                            {{ $result['domain_exists'] ? 'Exists' : 'Not Found' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>MX</th>
                                        <td>
                                            {{ $result['mx_exists'] ? 'Found' : 'Not Found' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>SMTP Status</th>
                                        <td>
                                            {{ $result['smtp_status'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>SMTP Code</th>
                                        <td>
                                            {{ $result['smtp_code'] ?? '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Message</th>
                                        <td>
                                            {{ $result['message'] }}
                                        </td>
                                    </tr>

                                </table>

                            </div>

                        @endif


                        {{-- ========================================================= --}}
                        {{-- BULK RESULT --}}
                        {{-- ========================================================= --}}

                        @if(session('bulk_result_file'))

                            <div class="mt-4">

                                <div class="alert alert-success">

                                    <h5 class="mb-2">
                                        Email Verification Completed
                                    </h5>

                                    <p class="mb-3">
                                        Your verification results have been generated successfully.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'user.email.verification.download',
                                            ['fileName' => session('bulk_result_file')]
                                        ) }}"
                                        class="btn btn-success"
                                    >
                                        Download Result Excel
                                    </a>

                                </div>

                            </div>

                        @endif

                    </div> 
                </div>

            </div>

        </div>

    </div>

</section>
<style type="text/css">
    .validate-email
    {
       
        border: 1px solid #e2e2e2;
        padding: 10px;
        border-radius: 5px;
    }
    .or-divider { display: flex; align-items: center; justify-content: center; width: 100%; } 
    .or-divider span { display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; border: 2px solid #dee2e6; background: #fff; font-weight: 700; font-size: 14px; color: #6c757d; }

</style>
@endsection