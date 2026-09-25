

@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Edit Your Email</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Edit your email before sending.
    </p>

    <form action="{{ route('user.campaigns.editor.store',$campaign) }}" id="editorForm"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="accountInfo">

            {{-- Contact Groups --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Selected Contact Group(s)</strong>
                </div>

                <div class="col-md-7">

                    <select name="group_ids[]" class="form-control" multiple size="6">

                        @foreach($groups as $group)

                            <option value="{{ $group->id }}"
                                {{ $campaign->groups->contains($group->id) ? 'selected' : '' }}>
                                {{ $group->group_name }}
                            </option>

                        @endforeach

                    </select>

                    <small class="text-muted">
                        Hold Ctrl to select multiple groups.
                    </small>

                </div>

            </div>

            {{-- Additional Recipients --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Additional Recipients</strong>
                </div>

                <div class="col-md-7">

                    <input
                        type="text"
                        name="additional_recipients"
                        class="form-control"
                        value="{{ old('additional_recipients',$campaign->additional_recipients) }}">

                    <small>
                        Separate multiple email addresses using commas.
                    </small>

                </div>

            </div>

            {{-- Campaign Name --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Email Campaign Name</strong>
                </div>

                <div class="col-md-7">

                    <input
                        type="text"
                        name="email_title"
                        class="form-control"
                        value="{{ old('email_title',$campaign->email_title) }}">

                </div>

            </div>

            {{-- Email Content --}}
            <div class="row mb-4">

                <div class="col-md-12">

                        <textarea
                            id="editor"
                            name="message"
                            rows="18"
                            class="form-control"
                        >{{ old('message', $editorContent) }}</textarea>

                </div>

            </div>

            {{-- Attachment --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Attachment</strong>
                </div>

                <div class="col-md-7">

                    <input
                        type="file"
                        name="attachment"
                        class="form-control">

                    @if($campaign->attachment)

                        <small class="text-success">

                            Current :
                            <a href="{{ asset('storage/'.$campaign->attachment) }}"
                               target="_blank">

                                View Attachment

                            </a>

                        </small>

                        <div class="mt-2">

                            <strong>
                                Current attachment:
                            </strong>

                            {{ basename($campaign->attachment) }}

                            <br>

                            <label class="mt-1">

                                <input
                                    type="checkbox"
                                    name="remove_attachment"
                                    value="1"
                                >

                                Remove attachment

                            </label>

                        </div>

                    @endif

                    @error('attachment')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

            {{-- Save Template --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Save this template?</strong>
                </div>

                <div class="col-md-7">

                    <label class="mr-4">

                        <input type="radio"
                               name="save_option"
                               value="1"
                               {{ old('save_option',$campaign->save_option)==1?'checked':'' }}>

                        Yes

                    </label>

                    <label>

                        <input type="radio"
                               name="save_option"
                               value="0"
                               {{ old('save_option',$campaign->save_option)==0?'checked':'' }}>

                        No

                    </label>

                </div>

            </div>

            {{-- Campaign Footer --}}
            <div class="row mb-5">

                <div class="col-md-3">
                    <strong>Show Company Logo</strong>
                </div>

                <div class="col-md-7">

                    <label class="mr-4">

                        <input type="radio"
                               name="campaign_footer"
                               value="1"
                               {{ old('campaign_footer',$campaign->campaign_footer)==1?'checked':'' }}>

                        Yes

                    </label>

                    <label>

                        <input type="radio"
                               name="campaign_footer"
                               value="0"
                               {{ old('campaign_footer',$campaign->campaign_footer)==0?'checked':'' }}>

                        No

                    </label>

                </div>

            </div>

            {{-- Buttons --}}
            <div class="text-center">

                <a href="{{ route('user.campaigns.templates',$campaign) }}"
                   class="btn btn-warning">

                    Back

                </a>

                <button class="btn btn-success">

                    Save & Next

                </button>

            </div>

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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function () {

    $('#editor').summernote({
        height: 700,

        toolbar: [
            ['style', ['style']],

            ['font', [
                'bold',
                'italic',
                'underline',
                'strikethrough',
                'superscript',
                'subscript',
                'clear'
            ]],

            ['fontname', ['fontname']],

            ['fontsize', ['fontsize']],

            ['color', ['color']],

            ['para', [
                'ul',
                'ol',
                'paragraph',
                'height'
            ]],

            ['table', ['table']],

            ['insert', [
                'link',
                'picture',
                'video',
                'hr'
            ]],

            ['view', [
                'fullscreen',
                'codeview',
                'help'
            ]],

            ['history', [
                'undo',
                'redo'
            ]]
        ]
    });

});
</script>


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

    $('#editorForm').on('submit', function (e) {

        const emailTitle = $('input[name="email_title"]').val().trim();
        const emailMessage = $('input[name="message"]').val().trim();

        const selectedTemplate =
            $('input[name="group_ids[]"]:checked');

        if (selectedTemplate.length === 0) {

            e.preventDefault();

            showValidation(
                'Group Required',
                'Please select atleast 1 group before continuing.'
            );

            return false;
        }

        if (emailTitle === '') {

            e.preventDefault();

            showValidation(
                'Email Campaign Name Required',
                'Please enter an email campaign name before continuing.'
            );

            return false;
        }

        if (emailMessage === '') {

            e.preventDefault();

            showValidation(
                'Email message Required',
                'Please enter email message or content before continuing.'
            );

            return false;
        }

        // Allow normal form submission
    });

</script>
@endpush