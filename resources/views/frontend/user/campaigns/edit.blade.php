@extends('frontend.layouts.dashboard')

@section('title', 'Edit Email Campaign')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Edit Message Header</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Update the information for your email campaign.
    </p>

    <p>
        The message header in an email contains information about the sender and recipient.
    </p>

    <div class="border p-3 mb-4" style="border:dashed #999 !important;">
        <strong>From:</strong> "email@domain.com"<br>
        <strong>To:</strong> "email@domain.com"<br>
        <strong>Subject:</strong> Email Subject Line
    </div>

    <div class="accountInfo">

        <form method="POST"
              action="{{ route('user.campaigns.update',$campaign) }}" id="templateForm">

            @csrf
            @method('PUT')

            <div class="contactForm">

                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>Subject</strong>
                    </div>

                    <div class="col-lg-6">

                        <input type="text"
                               name="email_subject"
                               class="form-control"
                               value="{{ old('email_subject',$campaign->email_subject) }}">

                        @error('email_subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                <p class="mb-4">
                    This is the subject line displayed to your recipients.
                </p>

                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>From Name</strong>
                    </div>

                    <div class="col-lg-6">

                        <input type="text"
                               name="from_name"
                               class="form-control"
                               value="{{ old('from_name',$campaign->from_name) }}">

                        @error('from_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                <p class="mb-4">
                    Use a recognizable sender name.
                </p>

                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>Campaign Name</strong>
                    </div>

                    <div class="col-lg-6">

                        <input type="text"
                               name="email_title"
                               class="form-control"
                               value="{{ old('email_title',$campaign->email_title) }}">

                        @error('email_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                <p class="mb-4">
                    This name is only for your reference.
                </p>

                <div class="row mb-4">

                    <div class="col-lg-3">
                        <strong>From Email</strong>
                    </div>

                    <div class="col-lg-6">

                        <input type="email"
                               class="form-control"
                               value="{{ auth()->user()->email }}"
                               readonly>

                    </div>

                </div>

                <div class="mt-4">

                    <a href="{{ route('user.campaigns.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-success">
                        Update & Next
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<style>

.constant-email-alert {
    border-radius: 10px;
    padding: 25px;
}

.constant-email-alert-title {
    color: #333;
    font-size: 23px;
}

.constant-email-alert-button {
    border-radius: 5px !important;
    padding: 10px 30px !important;
    font-weight: 600 !important;
}

</style>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showValidation(title, message) {

            Swal.fire({
                icon: 'warning',
                title: title,
                html: message,
                confirmButtonText: 'OK',

                confirmButtonColor: '#f79432',

                background: '#ffffff',

                customClass: {
                    popup: 'constant-email-alert',
                    title: 'constant-email-alert-title',
                    confirmButton: 'constant-email-alert-button'
                },

                allowOutsideClick: false
            });

        }

        $('#templateForm').on('submit', function (e) {

            const emailSubject = $('input[name="email_subject"]').val().trim();
            const campaignName = $('input[name="email_title"]').val().trim();

            if (emailSubject === '') {

                e.preventDefault();

                showValidation(
                    'Subject Required',
                    'Please enter an email subject before continuing.'
                );

                return false;
            }

            if (campaignName === '') {

                e.preventDefault();

                showValidation(
                    'Campaign Name Required',
                    'Please enter campaign name before continuing.'
                );

                return false;
            }

            // Allow normal form submission
        });

    </script>
@endpush