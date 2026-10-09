@extends('frontend.layouts.app')

@section('content')

<style>

    .forward-page {
    max-width: 760px;
    margin: 35px auto;
    padding: 0 20px;
    font-family: Arial, Helvetica, sans-serif;
    color: #334155;
}

.forward-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 28px 32px;
}

.forward-title {
    margin: 0;
    color: #f15b55;
    font-size: 26px;
    font-weight: 500;
}

.forward-subtitle {
    color: #64748b;
    font-size: 13px;
    margin: 8px 0 25px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e5e7eb;
}

.forward-form-group {
    display: grid;
    grid-template-columns: 155px minmax(0, 1fr);
    gap: 15px;
    margin-bottom: 20px;
    align-items: start;
}

.forward-form-group label {
    font-size: 13px;
    padding-top: 11px;
    margin: 0;
    font-weight: 500;
}

.optional-label {
    color: #94a3b8;
    font-size: 11px;
    font-weight: 400;
}

.forward-input-wrap {
    min-width: 0;
}

.forward-input-wrap .form-control {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #d7dee7;
    border-radius: 4px;
    padding: 10px 12px;
    font-size: 14px;
    color: #334155;
    background: #fff;
    box-shadow: none;
}

.forward-input-wrap input.form-control {
    height: 42px;
}

.forward-input-wrap textarea.form-control {
    min-height: 110px;
    resize: vertical;
}

.forward-input-wrap .form-control:focus {
    border-color: #f58220;
    outline: none;
    box-shadow: 0 0 0 2px rgba(245, 130, 32, 0.12);
}

.forward-input-wrap .form-control.is-invalid {
    border-color: #dc3545;
}

.forward-error {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}

.forward-actions {
    margin-left: 170px;
    margin-top: 5px;
}

.forward-submit {
    border: 0;
    border-radius: 4px;
    background: #f58220;
    color: #fff;
    padding: 11px 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.forward-submit:hover {
    background: #df7015;
}

@media (max-width: 575px) {
    .forward-page {
        margin: 20px auto;
        padding: 0 12px;
    }

    .forward-card {
        padding: 22px 18px;
    }

    .forward-form-group {
        grid-template-columns: 1fr;
        gap: 7px;
        margin-bottom: 16px;
    }

    .forward-form-group label {
        padding-top: 0;
    }

    .forward-actions {
        margin-left: 0;
    }
}
</style>

<section class="email-to-friend-section">

<div class="container">
<div class="forward-page">
    <div class="forward-card">
        <h2 class="forward-title">Email to a Friend</h2>
        <p class="forward-subtitle">
            Share this email with someone who might find it useful.
        </p>
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
                value="{{ $campaignId }}"
            >

            <div class="forward-form-group">
                <label for="first_name">First Name</label>
                <div class="forward-input-wrap">
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        class="form-control @error('first_name') is-invalid @enderror"
                        required
                    >
                    @error('first_name')
                        <div class="forward-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="forward-form-group">
                <label for="last_name">Last Name</label>
                <div class="forward-input-wrap">
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        class="form-control @error('last_name') is-invalid @enderror"
                        required
                    >
                    @error('last_name')
                        <div class="forward-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="forward-form-group">
                <label for="friend_email">Friend's Email</label>
                <div class="forward-input-wrap">
                    <input
                        type="email"
                        id="friend_email"
                        name="friend_email"
                        value="{{ old('friend_email') }}"
                        class="form-control @error('friend_email') is-invalid @enderror"
                        required
                    >
                    @error('friend_email')
                        <div class="forward-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- <div class="forward-form-group">
                <label for="message">
                    Message <span class="optional-label">(Optional)</span>
                </label>
                <div class="forward-input-wrap">
                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        maxlength="2000"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Add a personal message (optional)"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="forward-error">{{ $message }}</div>
                    @enderror
                </div>
            </div> -->

            <div class="forward-actions">
                <button type="submit" class="forward-submit">
                    Send Email
                </button>
            </div>
        </form>
    </div>
</div>
</div>
</section>

<!-- <section class="email-to-friend-section">

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
                    value="{{ $campaignId }}"
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

</section> -->

@endsection