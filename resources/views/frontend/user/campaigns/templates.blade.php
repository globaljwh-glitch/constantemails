@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Template List</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        <b>Choose an Email Template</b>
        <p>
            Here you can choose a template that best suits your message. Using a template with a layout that matches the contents of your email will help you to efficiently present your message.
        </p>
        <p>
            All of <b>our templates are editable!</b> When using our templates you can use our easy editor, or switch to source (html) mode. Things like changing pictures, layouts, frames, and text are very easy to modify.
        </p>
        <p>
            If you have previously created a custom template, you may search your <a href="#templateList">Custom Template List</a> from the drop down menu.
        </p>
        <p>
            Pick a Preformated Email Template or a Custom template of your own, and then hit <b>"Save Next"</b>.
        </p>
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
                        @else 
                            <img src="{{ asset('assets/frontend/images/default-template.png') }}"
                                class="card-img-top"
                                style="height:180px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <div class="form-check">

                                <!-- <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="default_{{ $template->id }}"
                                    id="default{{ $template->id }}"

                                    {{ $campaign->template_id == $template->id ? 'checked' : '' }}
                                > -->

                                @php
                                    $selectedTemplateId = old(
                                        'template_id',
                                        $campaign->template_id ?? session('campaign_draft.template_id')
                                    );

                                    $selectedTemplateType = old(
                                        'template_type',
                                        $campaign->template_type ?? session('campaign_draft.template_type')
                                    );
                                @endphp

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="default_{{ $template->id }}"
                                    id="default{{ $template->id }}"
                                    {{ $selectedTemplateType === 'default'
                                        && (int) $selectedTemplateId === (int) $template->id
                                        ? 'checked'
                                        : '' }}
                                >

                                <label class="form-check-label"
                                       for="default{{ $template->id }}">

                                    <strong>{{ ucwords($template->name) }}</strong>

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
        <h4 class="mb-3" id="templateList">Custom Made Templates</h4>
        <p>
            If you'd like to use a template of your own, you may do so by picking one from the drop down menu below.
        </p>
        <p>
            <b>Pick template from saved template list (optional) :</b>
        </p>
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

                                <!-- <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="user_{{ $template->id }}"
                                    id="user{{ $template->id }}"
                                > -->

                                @php
                                    $selectedTemplateId = old(
                                        'template_id',
                                        $campaign->template_id ?? session('campaign_draft.template_id')
                                    );

                                    $selectedTemplateType = old(
                                        'template_type',
                                        $campaign->template_type ?? session('campaign_draft.template_type')
                                    );
                                @endphp

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="template_type"
                                    value="user_{{ $template->id }}"
                                    id="user{{ $template->id }}"
                                    {{ $selectedTemplateType === 'user'
                                        && (int) $selectedTemplateId === (int) $template->id
                                        ? 'checked'
                                        : '' }}
                                >

                                <label class="form-check-label"
                                       for="user{{ $template->id }}">

                                    <strong>{{ ucwords($template->template_title) }}</strong>

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
        <p>None of these templates is doing it for you?</p>
        <p>
            <a href="{{ route('user.saved-templates.create') }}">Create your own template!</a>
        </p>
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