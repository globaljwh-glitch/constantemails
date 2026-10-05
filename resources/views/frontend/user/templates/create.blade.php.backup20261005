@extends('frontend.layouts.app')

@section('title', 'Add Template')

@push('styles')
    <link
        href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css"
        rel="stylesheet"
    >
@endpush

@section('content')

<section class="contentContainer">

    <div class="container">

        <div class="row">

            {{-- =====================================================
                 SIDEBAR
            ====================================================== --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>


            {{-- =====================================================
                 MAIN CONTENT
            ====================================================== --}}
            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- =================================================
                         PAGE HEADER
                    ================================================== --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="borderBottom">

                                <h2>
                                    Add Template
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SUCCESS MESSAGE
                    ================================================== --}}
                    @if(session('success'))

                        <p
                            align="center"
                            class="text-success mt-3"
                        >
                            {{ session('success') }}
                        </p>

                    @endif


                    {{-- =================================================
                         ERROR MESSAGE
                    ================================================== --}}
                    @if($errors->any())

                        <div class="alert alert-danger mt-3">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <div class="row">

                        <div class="col-lg-12">

                            <p class="mt-4 mb-2">

                                <b>
                                    Design Your Template Here
                                </b>

                                <br>

                                Remember you can change the appearance
                                of this form at will by simply changing
                                the code a bit. Don't know how,
                                click here to learn!

                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                         FORM
                    ================================================== --}}

                    <div class="accountInfo">

                        <form
                            name="frm_reg"
                            action="{{ route('user.saved-templates.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="contactForm">


                                {{-- =================================================
                                     TEMPLATE NAME
                                ================================================== --}}

                                <div class="row">

                                    <div class="col-lg-2 col-md-6 col-sm-6">

                                        <strong>
                                            *Template Name
                                        </strong>

                                    </div>


                                    <div class="col-lg-10 col-md-6 col-sm-6">

                                        <input
                                            type="text"
                                            name="template_title"
                                            maxlength="255"
                                            class="mod-input"
                                            value="{{ old('template_title') }}"
                                            required
                                        >

                                    </div>

                                </div>


                                {{-- =================================================
                                     CONTENT
                                ================================================== --}}

                                <div class="row mt-4">

                                    <div class="col-lg-2 col-md-6 col-sm-6">

                                        <strong>
                                            *Content
                                        </strong>

                                    </div>


                                    <div class="col-lg-10 col-md-6 col-sm-6">

                                        <p class="mt-2">

                                            You will be given the option to
                                            use our templates or yours when
                                            composing email campaigns.

                                        </p>


                                        <textarea
                                            name="template_content"
                                            id="template_content"
                                            class="form-control"
                                        >{{ old('template_content') }}</textarea>

                                    </div>

                                </div>


                                {{-- =================================================
                                     BUTTONS
                                ================================================== --}}

                                <div class="row borderBottom mt-4">

                                    <div class="col-md-12 col-lg-12">

                                        <div class="text-right">

                                            <a
                                                href="{{ route('user.saved-templates.index') }}"
                                                class="btn btn-default orangeBg text-white"
                                            >
                                                Back
                                            </a>


                                            <button
                                                type="submit"
                                                value="Save"
                                                class="btn btn-success"
                                                name="register"
                                                title="Save"
                                            >
                                                Save
                                            </button>

                                        </div>

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