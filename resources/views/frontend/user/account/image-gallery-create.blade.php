@extends('frontend.layouts.app')

@section('title', 'Upload Image')

@section('content')

    @include('frontend.includes.banner', ['title' => 'Upload Image'])

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

                        {{-- Header --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="borderBottom">
                                    <h2>Upload Image</h2>
                                </div>
                            </div>
                        </div>


                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif


                        {{-- Error Message --}}
                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif


                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="galleryUploadIntro mt-4">
                            <p>
                                Upload an image to your gallery.
                                You can upload
                                <strong>JPG, PNG or GIF</strong>
                                files up to
                                <strong>1 MB</strong>.
                            </p>
                        </div>


                        {{-- Upload Form --}}
                        <div class="accountInfo">

                            <form
                                method="POST"
                                action="{{ route('user.image-gallery.store') }}"
                                enctype="multipart/form-data"
                            >

                                @csrf

                                <div class="contactForm">


                                    {{-- Image --}}
                                    <div class="row mb-4">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <strong>* Image:</strong>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-6">

                                            <input
                                                type="file"
                                                name="image"
                                                id="image"
                                                accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/png,image/gif"
                                                required
                                            >

                                            <div class="uploadHelpText">
                                                JPG, PNG or GIF up to 1 MB
                                            </div>

                                            @error('image')
                                                <div class="fieldError">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            {{-- Image Preview --}}
                                            <div
                                                id="imagePreviewContainer"
                                                class="imagePreviewContainer"
                                                style="display:none;"
                                            >
                                                <img
                                                    id="imagePreview"
                                                    src=""
                                                    alt="Image Preview"
                                                >
                                            </div>

                                        </div>

                                    </div>


                                    {{-- Caption --}}
                                    <div class="row mb-4">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <strong>* Caption:</strong>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-6">

                                            <input
                                                type="text"
                                                name="caption"
                                                id="caption"
                                                class="form_input"
                                                value="{{ old('caption') }}"
                                                maxlength="15"
                                                required
                                            >

                                            <div class="uploadHelpText">
                                                Maximum 15 characters.
                                            </div>

                                            @error('caption')
                                                <div class="fieldError">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Buttons --}}
                                    <div class="row mt-4">

                                        <div class="col-lg-4"></div>

                                        <div class="col-lg-8">

                                            <button
                                                type="submit"
                                                class="submitButton"
                                            >
                                                Upload Image
                                            </button>

                                            <a
                                                href="{{ route('user.image-gallery.index') }}"
                                                class="cancelButton"
                                            >
                                                Cancel
                                            </a>

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

@endsection


@push('styles')

<style>

    /* --------------------------------
       Intro
    -------------------------------- */

    .galleryUploadIntro {
        color: #555;
        line-height: 1.7;
    }


    /* --------------------------------
       Help Text
    -------------------------------- */

    .uploadHelpText {
        margin-top: 7px;
        color: #999;
        font-size: 12px;
    }


    /* --------------------------------
       Validation
    -------------------------------- */

    .fieldError {
        margin-top: 6px;
        color: #e3342f;
        font-size: 13px;
    }


    /* --------------------------------
       Image Preview
    -------------------------------- */

    .imagePreviewContainer {
        width: 180px;
        height: 140px;
        margin-top: 15px;
        padding: 5px;
        border: 1px solid #ddd;
        background: #f8f8f8;
    }

    .imagePreviewContainer img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }


    /* --------------------------------
       Cancel Button
    -------------------------------- */

    .cancelButton {
        display: inline-block;
        margin-left: 10px;
        padding: 11px 20px;
        background: #777;
        color: #fff !important;
        text-decoration: none;
        border-radius: 3px;
        vertical-align: middle;
    }

    .cancelButton:hover {
        background: #555;
        color: #fff !important;
    }


    /* --------------------------------
       Mobile
    -------------------------------- */

    @media (max-width: 767px) {

        .cancelButton {
            margin-left: 5px;
        }

    }

</style>

@endpush


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');

    if (!imageInput) {
        return;
    }

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            previewContainer.style.display = 'none';
            preview.src = '';
            return;
        }

        // Client-side size check
        if (file.size > 1024 * 1024) {

            alert('Please upload an image below 1 MB.');

            this.value = '';
            previewContainer.style.display = 'none';
            preview.src = '';

            return;
        }

        // Preview
        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            previewContainer.style.display = 'block';
        };

        reader.readAsDataURL(file);
    });

});
</script>

@endpush