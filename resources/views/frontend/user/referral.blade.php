@extends('frontend.layouts.app')

@section('title', 'Refer a Friend')

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

                                <h2>Refer a Friend</h2>

                            </div>

                        </div>

                    </div>


                    {{-- Success --}}
                    @if(session('success'))

                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>

                    @endif


                    {{-- Warning --}}
                    @if(session('warning'))

                        <div class="alert alert-warning mt-3">
                            {{ session('warning') }}
                        </div>

                    @endif


                    {{-- Errors --}}
                    @if($errors->any())

                        <div class="alert alert-danger mt-3">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <div class="mt-4">

                        <p>
                            Email more contacts by referring us to your friends!
                            Our Refer-A-Friend Program was created to reward our
                            customer's loyalty and to help them share our service.
                        </p>

                        <p>
                            The way it works is very simple. Just refer us to your
                            friends — make sure they have a valid email address —
                            wait for our confirmation, then get up to 50 free
                            contacts per friend, that's it!
                        </p>

                        <p>
                            Fill out the form below to get started.
                        </p>

                    </div>


                    {{-- Referral Form --}}

                    <div class="accountInfo mt-4">
                        <div class="contactForm">

                            <form method="POST" action="{{ route('user.referral.store') }}">
                                @csrf

                                {{-- Friend's Name --}}
                                <div class="row mb-4 align-items-center">

                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <strong>Friend's name:</strong>
                                    </div>

                                    <div class="col-lg-6 col-md-8 col-sm-12">
                                        <input
                                            type="text"
                                            name="friend_name"
                                            value="{{ old('friend_name') }}"
                                            maxlength="100"
                                            class="form-control"
                                            required
                                        >

                                        @error('friend_name')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>

                                </div>


                                {{-- Friend's Email --}}
                                <div class="row mb-4 align-items-center">

                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <strong>Friend's email:</strong>
                                    </div>

                                    <div class="col-lg-6 col-md-8 col-sm-12">
                                        <input
                                            type="email"
                                            name="refereEmail"
                                            value="{{ old('refereEmail') }}"
                                            maxlength="50"
                                            class="form-control"
                                            required
                                        >

                                        @error('refereEmail')
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>

                                </div>


                                {{-- Submit --}}
                                <div class="row">

                                    <div class="col-lg-3 col-md-4"></div>

                                    <div class="col-lg-6 col-md-8">
                                        <button
                                            type="submit"
                                            class="submitButton"
                                        >
                                            Submit
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>


                    {{-- Existing Referrals --}}
                    @if($referrals->count())

                        <div class="mt-5">

                            <h3>
                                My Referrals
                            </h3>

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($referrals as $referral)

                                            <tr>

                                                <td>
                                                    {{ $referral->refereEmail }}
                                                </td>

                                                <td>
                                                    {{ $referral->submittedAt?->format('M d, Y') }}
                                                </td>

                                                <td>

                                                    @if($referral->Status == 0)

                                                        <span class="text-warning">
                                                            Pending
                                                        </span>

                                                    @elseif($referral->Status == 1)

                                                        <span class="text-success">
                                                            Registered
                                                        </span>

                                                    @elseif($referral->Status == 2)

                                                        <span class="text-success">
                                                            Completed
                                                        </span>

                                                    @else

                                                        <span>
                                                            Unknown
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    @endif


                    <div class="mt-4">

                        <p class="small text-muted">

                            <i class="fa fa-warning"></i>

                            Friend's email addresses must be valid.
                            The system will check your friend's activity
                            to verify that it is really a person's email
                            address and not a computer entered address.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection