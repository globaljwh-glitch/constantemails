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
          method="POST">

        @csrf

        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

        <h4 class="mb-3">Default Templates</h4>

        <div class="row">

            @forelse($defaultTemplates as $template)

                <div class="col-md-4 mb-4">

                    <div class="card h-100">

                        @if($template->template_image)
                            <img src="{{ asset('uploads/default_templates/'.$template->template_image) }}"
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

                                    <strong>{{ $template->template_name }}</strong>

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

                                    <strong>{{ $template->mail_template_name }}</strong>

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

@endsection