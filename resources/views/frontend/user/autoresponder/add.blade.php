@extends('frontend.layouts.app')

@section('title', 'Add Auto Responder')

@section('content')

<section class="contentContainer">
    <div class="container">

        <div class="row">

            {{-- SIDEBAR --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- PAGE HEADER --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="borderBottom">
                                <h2>
                                    @if(request('action') === 'copy')
                                        View Auto Responder
                                    @else
                                        Add Auto Responder
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="accountInfo">

                        {{-- =====================================================
                             STEP 1 - CHOOSE AUTORESPONDER TYPE
                        ====================================================== --}}
                          <form
                              name="frm_reg"
                              method="POST"
                              action="{{ route('user.autoresponders.type') }}"
                          >
                              @csrf

                            <div class="contactForm">

                                <p>
                                    How will you create your Autoresponder message?
                                </p>

                                {{-- New Autoresponder --}}
                                <div class="row">
                                    <div class="col-md-12">

                                        <input
                                            class="text-left mr-2"
                                            type="radio"
                                            name="auto"
                                            value="new"
                                            checked
                                            style="width:auto; height:auto;"
                                        >

                                        <b>New Autoresponder</b>
                                        -
                                        Start a new fresh Autoresponder using any
                                        email template.

                                    </div>
                                </div>

                                {{-- Existing Campaign --}}
                                <div class="row mt-3">
                                    <div class="col-md-12 pr-0">

                                        <input
                                            class="text-left mr-2"
                                            type="radio"
                                            name="auto"
                                            value="copy"
                                            style="width:auto; height:auto;"
                                        >

                                        <b>Existing Email Campaign</b>
                                        -
                                        Use a copy of an existing email campaign.

                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="row mt-4">

                                    <div class="col-lg-4 col-md-6 col-sm-6">

                                        <button
                                            type="button"
                                            onclick="history.back()"
                                            title="Back"
                                            class="submitButton mb-0"
                                        >
                                            Back
                                        </button>

                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6">

                                        <button
                                            type="submit"
                                            name="save"
                                            value="1"
                                            title="Save"
                                            class="submitButton mb-0"
                                        >
                                            Save
                                        </button>

                                    </div>

                                </div>

                            </div>
                        </form>


                        {{-- =====================================================
                             STEP 2 - MESSAGE HEADER
                        ====================================================== --}}
                          <form
                              method="POST"
                              name="frm_details"
                              action="{{ route('user.autoresponders.store') }}"
                          >
                              @csrf

                            <div class="contactForm">

                                <p>
                                    In this step, you will be providing the
                                    information for your message header.
                                </p>

                                <p>
                                    The message header in an email is what
                                    contains information about the sender and
                                    recipient. On some email service providers
                                    it looks like this:
                                </p>


                                {{-- SUBJECT --}}
                                <div class="row">

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <strong>Subject</strong>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            class="mod-input"
                                            maxlength="255"
                                            id="subject"
                                            name="subject"
                                            
                                            value="{{ old('subject', session('responder_arr.subject')) }}"
                                        >

                                        @error('subject')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    <div class="col-lg-12">
                                        <p>
                                            This is the subject line that will
                                            be displayed when your email arrives
                                            to its recipient. Make sure it is
                                            something your recipients
                                            <strong>trust</strong> so they don't
                                            discard it.
                                        </p>
                                    </div>

                                </div>


                                {{-- FROM NAME --}}
                                <div class="row mt-3">

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <strong>From Name</strong>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            class="mod-input"
                                            maxlength="255"
                                            name="sender_name"
                                            value="{{ old('sender_name', session('responder_arr.sender_name')) }}"
                                        >

                                        @error('sender_name')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    <div class="col-lg-12">
                                        <p>
                                            Try using a name that your contacts
                                            know so they will quickly recognize
                                            it and open it.
                                        </p>
                                    </div>

                                </div>


                                {{-- AUTORESPONDER NAME --}}
                                <div class="row mt-3">

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <strong>Autoresponder Name</strong>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            class="mod-input"
                                            maxlength="255"
                                            name="auto_responder_name"
                                            value="{{ old('auto_responder_name', session('responder_arr.auto_responder_name')) }}"
                                        >

                                        @error('auto_responder_name')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                        {{-- Preserve mode --}}
                                        <input
                                            type="hidden"
                                            name="mode"
                                            value="{{ request('mode', session('responder_arr.mode')) }}"
                                        >

                                    </div>

                                    <div class="col-lg-12">

                                        <p>
                                            The Autoresponder Name
                                            <u>
                                                <strong>will not be displayed</strong>
                                            </u>
                                            in your emails. We only require it
                                            so you can track it by a name in your
                                            email statistics.
                                        </p>

                                    </div>

                                </div>


                                {{-- SAVE & NEXT --}}
                                <div class="row mt-4">

                                    <div class="col-md-4 col-lg-12">

                                        <button
                                            type="submit"
                                            name="register"
                                            value="1"
                                            title="Save & Next"
                                            class="submitButton mb-0"
                                        >
                                            Save &amp; Next &gt;&gt;
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