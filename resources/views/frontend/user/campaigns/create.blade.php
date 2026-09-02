@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Message Header</h2>

                @if(session('success'))
                    <p class="text-center text-success">
                        {{ session('success') }}
                    </p>
                @endif

                @if(session('error'))
                    <p class="text-center text-danger">
                        {{ session('error') }}
                    </p>
                @endif

                @if(isset($upgradeRequired) && $upgradeRequired)
                    <p class="text-center">
                        If not, please
                        <a href="{{ route('pricing') }}">Upgrade Your Package</a>
                        or
                        <a href="{{ route('contact') }}">Contact Us</a>.
                    </p>
                @endif

            </div>
        </div>
    </div>

    <p class="mt-4">
        In this step, you will provide the information for your message header.
    </p>

    <p>
        The message header in an email contains information about the sender and recipient.
        On some email providers it looks like this:
    </p>

    <div class="border border-dark p-3 mb-4" style="border-style:dashed !important;">
        <strong>From:</strong> "email@domain.com"<br>
        <strong>To:</strong> "email@domain.com"<br>
        <strong>Subject:</strong> Email's subject line
    </div>

    <p>
        <strong>Enter your email header information below:</strong>
    </p>

    <form action="{{ route('user.campaigns.store') }}" method="POST">

        @csrf

        <div class="accountInfo">

            <div class="contactForm">

                {{-- Subject --}}
                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>Subject</strong>
                    </div>

                    <div class="col-lg-6">
                        <input
                            type="text"
                            name="email_subject"
                            class="form-control"
                            maxlength="255"
                            value="{{ old('subject', $campaign->subject ?? '') }}">
                    </div>

                    <div class="col-lg-9 offset-lg-3 mt-2">
                        <small class="text-muted">
                            This is the subject line that recipients will see.
                            Choose something trustworthy so recipients recognize it.
                        </small>
                    </div>

                </div>

                {{-- From Name --}}
                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>"From" Name</strong>
                    </div>

                    <div class="col-lg-6">
                        <input
                            type="text"
                            name="from_name"
                            class="form-control"
                            maxlength="255"
                            value="{{ old('from_name', $campaign->from_name ?? auth()->user()->name) }}">
                    </div>

                    <div class="col-lg-9 offset-lg-3 mt-2">
                        <small class="text-muted">
                            Use a familiar name so recipients immediately recognize your email.
                        </small>
                    </div>

                </div>

                {{-- Campaign Name --}}
                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>Campaign Name</strong>
                    </div>

                    <div class="col-lg-6">
                        <input
                            type="text"
                            name="email_title"
                            class="form-control"
                            maxlength="255"
                            value="{{ old('campaign_name', $campaign->campaign_name ?? '') }}">
                    </div>

                    <div class="col-lg-9 offset-lg-3 mt-2">
                        <small class="text-muted">
                            This name is only for your reference and will never appear in the email.
                        </small>
                    </div>

                </div>

                {{-- From Email --}}
                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>From Email</strong>
                    </div>

                    <div class="col-lg-6">
                        <!-- <input
                            type="email"
                            name="from_email"
                            class="form-control"
                            maxlength="255"
                            value="{{ old('from_email', $campaign->from_email ?? auth()->user()->email) }}"> -->
                        <input type="text"
                            class="form-control"
                            name="from_email"
                            value="{{ auth()->user()->email }}"
                            readonly>
                    </div>

                    <div class="col-lg-9 offset-lg-3 mt-2">
                        <small class="text-muted">
                            This email address will appear as the sender of your campaign.
                        </small>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-9 offset-lg-3">

                        <button
                            type="submit"
                            class="submitButton">
                            Update & Continue
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection