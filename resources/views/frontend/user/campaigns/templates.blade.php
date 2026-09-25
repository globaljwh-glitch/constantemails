@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Select Email Template</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Select one of the available templates for this email campaign.
    </p>

    <form action="{{ route('user.campaigns.templates.store', $campaign) }}"
          method="POST" id="templateForm">

        @csrf

        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

        <h4 class="mb-3">Default Templates</h4>

        <div class="row">

            @forelse($defaultTemplates as $template)

                <div class="col-md-4 mb-4">

                    <div class="card h-100">

                        @if($template->thumbnail)
                            <img src="{{ asset('storage/'.$template->thumbnail) }}"
                                 class="card-img-top"
                                 style="height:180px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="default_{{ $template->id }}"
                                    id="default{{ $template->id }}"

                                    {{ $campaign->template_id == $template->id ? 'checked' : '' }}
                                >

                                <label class="form-check-label"
                                       for="default{{ $template->id }}">

                                    <strong>{{ $template->name }}</strong>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <p>No default templates found.</p>
                </div>

            @endforelse

        </div>

        <hr class="my-5">

        <h4 class="mb-3">My Templates</h4>

        <div class="row">

            @forelse($userTemplates as $template)

                <div class="col-md-4 mb-4">

                    <div class="card h-100">

                        @if($template->mail_template_image)
                            <img src="{{ asset('uploads/mail_templates/'.$template->mail_template_image) }}"
                                 class="card-img-top"
                                 style="height:180px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="user_{{ $template->id }}"
                                    id="user{{ $template->id }}"
                                >

                                <label class="form-check-label"
                                       for="user{{ $template->id }}">

                                    <strong>{{ $template->template_title }}</strong>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <p>No custom templates found.</p>
                </div>

            @endforelse

        </div>

        <div class="mt-4 d-flex justify-content-between">

            <a href="{{ route('user.campaigns.groups', $campaign) }}"
               class="btn btn-warning">
                Back
            </a>

            <button class="btn btn-success">
                Save & Next
            </button>

        </div>

    </form>

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

            const selectedTemplate =
                $('input[name="template_type"]:checked');

            if (selectedTemplate.length === 0) {

                e.preventDefault();

                showValidation(
                    'Template Required',
                    'Please select a template before continuing.'
                );

                return false;
            }

            // No e.preventDefault()
            // Form submits normally and Laravel redirects.
        });

    </script>
@endpush