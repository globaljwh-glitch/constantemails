@extends('frontend.layouts.app')

@section('content')

<style>
    .email-to-friend-section {
        padding: 55px 0 80px;
        min-height: 650px;
    }

    .email-to-friend-wrapper {
        max-width: 650px;
        margin: 0 auto;
    }

    .email-to-friend-title {
        color: #f12626;
        font-size: 24px;
        font-weight: 400;
        padding-bottom: 18px;
        margin-bottom: 45px;
        border-bottom: 1px solid #eeeeee;
    }

    .email-friend-form .form-group {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .email-friend-form label {
        width: 165px;
        padding-top: 9px;
        margin-bottom: 0;
        font-size: 14px;
        color: #333;
        font-weight: 400;
    }

    .email-friend-form .form-control {
        width: 315px;
        height: 42px;
        border: 1px solid #e1e1e1;
        border-radius: 0;
        box-shadow: none;
    }

    .email-friend-form textarea.form-control {
        height: 165px;
        resize: vertical;
    }

    .email-friend-form .form-control:focus {
        border-color: #f12626;
        box-shadow: none;
    }

    .email-friend-submit {
        margin-left: 165px;
        margin-top: 18px;
    }

    .email-friend-submit .btn {
        background: #f99b28;
        border: 0;
        color: #fff;
        padding: 7px 15px;
        border-radius: 2px;
        text-transform: lowercase;
    }

    .email-friend-submit .btn:hover {
        background: #e88a17;
        color: #fff;
    }

    .invalid-feedback {
        display: block;
        width: 315px;
        margin-left: 165px;
    }

    @media (max-width: 767px) {

        .email-to-friend-wrapper {
            padding: 0 20px;
        }

        .email-friend-form .form-group {
            display: block;
        }

        .email-friend-form label {
            display: block;
            width: 100%;
            margin-bottom: 7px;
        }

        .email-friend-form .form-control {
            width: 100%;
        }

        .email-friend-submit {
            margin-left: 0;
        }

        .invalid-feedback {
            width: 100%;
            margin-left: 0;
        }
    }
</style>

<section class="email-to-friend-section">

    <div class="container">

        <div class="email-to-friend-wrapper">

            <h2 class="email-to-friend-title">
                Email To Friend
            </h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form
                action="{{ route('forward.send', ['recipient' => $contactId]) }}"
                method="POST"
                class="email-friend-form"
            >

                @csrf

                <input
                    type="hidden"
                    name="campaign_id"
                    value="{{ $recipient->campaign_id }}"
                >

                <div class="form-group">
                    <label for="first_name">
                        First Name
                    </label>

                    <div>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name') }}"
                        >

                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label for="last_name">
                        Last Name
                    </label>

                    <div>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name') }}"
                        >

                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label for="friend_email">
                        Friends Email
                    </label>

                    <div>
                        <input
                            type="email"
                            name="friend_email"
                            id="friend_email"
                            class="form-control @error('friend_email') is-invalid @enderror"
                            value="{{ old('friend_email') }}"
                        >

                        @error('friend_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label for="message">
                        Message
                    </label>

                    <div>
                        <textarea
                            name="message"
                            id="message"
                            class="form-control @error('message') is-invalid @enderror"
                        >{{ old('message') }}</textarea>

                        @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="email-friend-submit">
                    <button type="submit" class="btn">
                        submit
                    </button>
                </div>

            </form>

        </div>

    </div>

</section>

@endsection