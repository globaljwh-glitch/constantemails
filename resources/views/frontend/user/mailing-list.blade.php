@extends('frontend.layouts.app')

@section('title', 'Join Mailing List')

@section('content')

<section class="contentContainer">

    <div class="container">

        <div class="row">

            {{-- Sidebar --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>


            {{-- Main Content --}}
            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- Page Header --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="borderBottom">

                                <h2>Join Mailing List</h2>

                            </div>

                        </div>

                    </div>


                    {{-- Description --}}
                    <p class="mt-4">
                        If you are looking to grow your email marketing list
                        without having to go collecting email addresses yourself,
                        you should try using a mailing list form.

                        A mailing list form will do the job for you by collecting
                        email addresses from a website.

                        If your business has a website or if you have a way to
                        place a mailing list form somewhere on the internet then
                        growing your mailing list will be much faster.
                    </p>


                    <p>
                        Copy (Ctrl-C) and paste (Ctrl-V) the HTML code below
                        for your Mailing List Form to your website, or any place
                        on the internet.
                    </p>


                    {{-- Mailing List Form --}}
                    <div class="accountInfo">

                        <form
                            name="frm_reg"
                            id="frm_reg"
                            action="{{ route('user.mailing-list.store') }}"
                            method="POST"
                        >

                            @csrf

                            <div class="contactForm">


                                {{-- Generated HTML Code --}}
                                <div class="row">

                                    <div class="col-lg-12">

                                        <textarea
                                            name="mailing_form"
                                            id="mailing_form"
                                            class="mod-input"
                                            style="height: 200px;"
                                            onclick="this.select();"
                                            readonly
                                        >{{ $mailForm ?? '' }}</textarea>

                                    </div>

                                </div>


                                {{-- Preview Description --}}
                                <div class="row">

                                    <div class="col-lg-12">

                                        <p class="mt-4 mb-5">
                                            Your standard form will look like
                                            the one below this text:
                                        </p>

                                    </div>

                                </div>


                                {{-- First Name --}}
                                <div class="row">

                                    <div class="col-lg-3 col-md-6 col-sm-6">

                                        <strong>*First name</strong>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            name="mailing_fName"
                                            value=""
                                            class="form-control"
                                            disabled
                                        >

                                    </div>

                                </div>


                                {{-- Last Name --}}
                                <div class="row">

                                    <div class="col-lg-3 col-md-6 col-sm-6">

                                        <strong>*Last name</strong>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            name="mailing_lName"
                                            value=""
                                            class="form-control"
                                            disabled
                                        >

                                    </div>

                                </div>


                                {{-- Email --}}
                                <div class="row">

                                    <div class="col-lg-3 col-md-6 col-sm-6">

                                        <strong>*Email</strong>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                        <input
                                            type="email"
                                            name="mailing_email"
                                            value=""
                                            class="form-control"
                                            disabled
                                        >

                                    </div>

                                </div>


                                {{-- Submit --}}
                                <div class="row borderBottom mt-4">

                                    <div class="col-md-12 col-lg-12">

                                        <button
                                            type="submit"
                                            name="submit"
                                            value="Submit"
                                            class="submitButton"
                                            title="Submit"
                                        >
                                            Submit
                                        </button>

                                    </div>

                                </div>


                                {{-- User ID --}}
                                <input
                                    type="hidden"
                                    name="mailing_user"
                                    value="user{{ auth()->id() }}"
                                >


                                {{-- Help Text --}}
                                <p class="mt-4">

                                    Remember you can change the appearance
                                    of this form at will by simply changing
                                    the code a bit.

                                    Don't know how,
                                    <a href="#">
                                        click here to learn!
                                    </a>

                                </p>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection