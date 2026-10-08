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
                    <div class="col-lg-12">

    

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
                            enctype="multipart/form-data"   >

                            @csrf

                            <div class="row">

                                {{-- Single Email --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
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


                                {{-- Excel --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Upload Excel File
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
                                class="btn btn-primary"
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

@endsection