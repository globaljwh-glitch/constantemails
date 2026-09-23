@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Edit Template</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        <strong>Design Your Template Here</strong>
    </p>

    <p>
        Remember you can change the appearance of this form by simply changing
        the code a bit. Don't know how,
        <a href="#">click here to learn!</a>
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('user.saved-templates.update', $template) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="row mt-4">

            {{-- Template Name --}}
            <div class="col-md-3">
                <label for="template_name">
                    <strong>*Template Name</strong>
                </label>
            </div>

            <div class="col-md-9">
                <input
                    type="text"
                    id="template_name"
                    name="template_title"
                    class="form-control"
                    value="{{ old('template_title', $template->template_title) }}"
                    required
                >
            </div>

        </div>

        <div class="row mt-4">

            {{-- Template Content --}}
            <div class="col-md-3">
                <label for="template_content">
                    <strong>*Content</strong>
                </label>
            </div>

            <div class="col-md-9">

                <textarea
                    name="template_content"
                    id="template_content"
                    class="form-control"
                    rows="18"
                    required
                >{{ old('template_content', $template->template_content) }}</textarea>

                <small class="text-muted">
                    You can use HTML to design your email template.
                </small>

            </div>

        </div>

        {{-- Buttons --}}
        <div class="row mt-4">

            <div class="col-md-3"></div>

            <div class="col-md-9">

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Save
                </button>

                <a
                    href="{{ url()->previous() }}"
                    class="btn btn-default orangeBg text-white ml-2"
                >
                    Back
                </a>

            </div>

        </div>

    </form>

</div>


{{-- =====================================================
     SUMMERNOTE
====================================================== --}}

@push('scripts')

    <script
        src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js">
    </script>

    <script>

        $(document).ready(function () {

            $('#template_content').summernote({

                height: 500,

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

@endpush

@endsection