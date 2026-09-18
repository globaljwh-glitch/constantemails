@extends('frontend.layouts.app')

@section('title', 'My Image Gallery')

@section('content')

    @include('frontend.includes.banner', ['title' => 'Image Gallery'])

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

                        {{-- Page Header --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="borderBottom">
                                    <h2>Image Gallery</h2>
                                </div>
                            </div>
                        </div>

                        {{-- Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Description --}}
                        <div class="galleryIntro mt-4">
                            <p>
                                You can upload only these formats:
                                <strong>JPG, PNG & GIF</strong> files.

                                <a
                                    href="{{ route('user.image-gallery.create') }}"
                                    class="linkButton ms-2"
                                >
                                    Upload Image
                                </a>
                            </p>
                        </div>


                        {{-- Gallery --}}
                        <div class="accountInfo">

                            @if($images->count())

                                <div class="list borderBottom">

                                    <div class="row">

                                        @foreach($images as $image)

                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                                                <div class="galleryItem">

                                                    {{-- Image --}}
                                                    <div class="galleryImage">

                                                        <a
                                                            href="{{ asset('storage/' . $image->image) }}"
                                                            target="_blank"
                                                            title="{{ $image->caption }}"
                                                        >
                                                            <img
                                                                src="{{ asset('storage/' . $image->image) }}"
                                                                alt="{{ $image->caption ?: 'Gallery Image' }}"
                                                                class="imgResponsive"
                                                            >
                                                        </a>

                                                    </div>


                                                    {{-- Image URL --}}
                                                    <div class="imageLink mt-2">

                                                        <input
                                                            type="text"
                                                            class="form_input imageUrlInput"
                                                            value="{{ Storage::url($image->image) }}"
                                                            readonly
                                                            onclick="this.select();"
                                                            title="Image URL"
                                                        >

                                                    </div>


                                                    {{-- Caption --}}
                                                    @if($image->caption)
                                                        <div class="templateName mt-2">
                                                            {{ ucfirst($image->caption) }}
                                                        </div>
                                                    @endif


                                                    {{-- Actions --}}
                                                    <div class="galleryActions mt-2">

                                                        <button
                                                            type="button"
                                                            class="copyImageUrl"
                                                            data-url="{{ Storage::url($image->image) }}"
                                                            title="Copy Image URL"
                                                        >
                                                            <i class="fa fa-copy"></i>
                                                        </button>


                                                        <form
                                                            method="POST"
                                                            action="{{ route('user.image-gallery.destroy', $image->id) }}"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this image?');"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="deleteImage"
                                                                title="Delete Image"
                                                            >
                                                                <i
                                                                    class="fa fa-trash"
                                                                    aria-hidden="true"
                                                                ></i>
                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>


                                {{-- Pagination --}}
                                @if($images->hasPages())

                                    <div class="galleryPagination mt-4">
                                        {{ $images->links() }}
                                    </div>

                                @endif

                            @else

                                {{-- Empty Gallery --}}
                                <div class="galleryEmptyState">

                                    <div class="galleryEmptyIcon">
                                        <i class="fa fa-picture-o"></i>
                                    </div>

                                    <h3>
                                        Your Image Gallery is Empty
                                    </h3>

                                    <p>
                                        You haven't uploaded any images yet.
                                    </p>

                                    <a
                                        href="{{ route('user.image-gallery.create') }}"
                                        class="submitButton"
                                    >
                                        Upload Image
                                    </a>

                                </div>

                            @endif

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
       Gallery Intro
    -------------------------------- */

    .galleryIntro p {
        color: #555;
        line-height: 1.7;
    }


    /* --------------------------------
       Gallery Item
    -------------------------------- */

    .galleryItem {
        padding: 12px;
        border: 1px solid #e5e5e5;
        background: #fff;
        transition: 0.2s ease;
    }

    .galleryItem:hover {
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }


    /* --------------------------------
       Gallery Image
    -------------------------------- */

    .galleryImage {
        width: 100%;
        height: 150px;
        overflow: hidden;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .galleryImage a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .galleryImage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.2s ease;
    }

    .galleryImage img:hover {
        transform: scale(1.03);
    }


    /* --------------------------------
       Image URL
    -------------------------------- */

    .imageLink {
        width: 100%;
    }

    .imageUrlInput {
        width: 100%;
        height: 32px;
        padding: 5px 7px;
        font-size: 11px;
        color: #666;
        background: #f8f8f8;
        border: 1px solid #ddd;
    }


    /* --------------------------------
       Caption
    -------------------------------- */

    .templateName {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        min-height: 20px;
    }


    /* --------------------------------
       Actions
    -------------------------------- */

    .galleryActions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .galleryActions button {
        border: 0;
        background: none;
        padding: 4px 7px;
        cursor: pointer;
        font-size: 15px;
    }

    .copyImageUrl {
        color: #555;
    }

    .copyImageUrl:hover {
        color: #ed2b2b;
    }

    .deleteImage {
        color: #ed2b2b;
    }

    .deleteImage:hover {
        color: #b00000;
    }


    /* --------------------------------
       Empty State
    -------------------------------- */

    .galleryEmptyState {
        text-align: center;
        padding: 50px 20px;
        border: 1px solid #eee;
        background: #fafafa;
    }

    .galleryEmptyIcon {
        width: 60px;
        height: 60px;
        line-height: 60px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #f3a03a;
        color: #fff;
        font-size: 25px;
    }

    .galleryEmptyState h3 {
        margin-bottom: 8px;
        font-size: 21px;
        color: #333;
    }

    .galleryEmptyState p {
        color: #777;
        margin-bottom: 20px;
    }

    .galleryEmptyState .submitButton {
        display: inline-block;
        text-decoration: none;
    }


    /* --------------------------------
       Pagination
    -------------------------------- */

    .galleryPagination {
        display: flex;
        justify-content: center;
    }


    /* --------------------------------
       Mobile
    -------------------------------- */

    @media (max-width: 767px) {

        .galleryImage {
            height: 180px;
        }

    }

</style>

@endpush


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.copyImageUrl').forEach(function (button) {

        button.addEventListener('click', function () {

            const url = this.getAttribute('data-url');

            navigator.clipboard.writeText(url)
                .then(() => {

                    const original = this.innerHTML;

                    this.innerHTML = '<i class="fa fa-check"></i>';

                    setTimeout(() => {
                        this.innerHTML = original;
                    }, 1500);

                })
                .catch(() => {

                    alert('Unable to copy image URL.');

                });

        });

    });

});
</script>

@endpush