@extends('admin.layouts.app')

@section('title', isset($article) ? 'Edit CMS Article | Constant Emails' : 'Create CMS Article | Constant Emails')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <style>
        .form-control,
        .custom-select {
            border: 1px solid #ccc;
            color: #888ea8;
            font-size: 15px;
            height: 48px;
        }

        .input-group-text {
            background-color: #f3f4f7;
            border-color: #ccc;
            color: #6156ce;
            font-weight: 600;
            padding: 0 15px;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #3862f5;
            box-shadow: none;
        }

        label {
            color: #3b3f5c;
            font-weight: 600;
            margin-bottom: 8px !important;
        }

        .is-invalid {
            border-color: #e7515a !important;
        }

        .editor-container {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 15px;
            background: #fff;
            min-height: 250px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>{{ isset($article) ? 'Edit CMS Article' : 'Add New CMS Article' }}</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="{{ route('cms-articles.index') }}">CMS</a></li>
                    <li class="active"><a href="#">{{ isset($article) ? 'Edit' : 'Create' }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12 col-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12">
                            <h4>Article Details</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <form id="articleForm"
                        action="{{ isset($article) ? route('cms-articles.update', $article->id) : route('cms-articles.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($article)) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="title">Article Title <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-notes"></i></span>
                                    </div>
                                    <input type="text" id="title" name="title"
                                        class="form-control form-control-rounded-right @error('title') is-invalid @enderror"
                                        placeholder="Enter article title..."
                                        value="{{ old('title', $article->title ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="status">Status</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-power-button"></i></span>
                                    </div>
                                    <select
                                        class="form-control form-control-rounded-right custom-select @error('status') is-invalid @enderror"
                                        id="status" name="status">
                                        <option value="Active" {{ old('status', $article->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Deactive" {{ old('status', $article->status ?? '') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <label>Article Content <span class="text-danger">*</span></label>
                                    <div class="text-right">
                                        <button type="button" id="editEditor" class="btn btn-primary btn-rounded btn-sm"><i
                                                class="flaticon-edit-fill-2 position-left"></i> Edit Editor</button>
                                        <button type="button" id="saveEditor" class="btn btn-success btn-rounded btn-sm"><i
                                                class="flaticon-fill-tick position-left"></i> Lock Editor</button>
                                    </div>
                                </div>

                                <div class="click2edit editor-container">
                                    {!! old('content', $article->content ?? '<p>Write your article here...</p>') !!}
                                </div>
                                <input type="hidden" name="content" id="hiddenContent">
                            </div>

                            <hr class="mt-4 mb-4 w-100">

                            <div class="col-md-12 text-right">
                                <a href="{{ route('cms-articles.index') }}" class="btn btn-dark btn-rounded mr-2">Cancel</a>
                                <button type="submit" class="btn btn-gradient-warning btn-rounded">
                                    {{ isset($article) ? 'Update Article' : 'Save Article' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $(document).ready(function () {
            // Start the editor
            $('#editEditor').on('click', function () {
                $('.click2edit').summernote({
                    focus: true,
                    height: 400,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });

            // Lock the editor
            $('#saveEditor').on('click', function () {
                $('.click2edit').summernote('destroy');
            });

            // On Form Submit, extract HTML into hidden input
            $('#articleForm').on('submit', function (e) {
                if ($('.click2edit').hasClass('summernote-active') || $('.note-editor').length) {
                    $('.click2edit').summernote('destroy');
                }

                let contentHTML = $('.click2edit').html();
                $('#hiddenContent').val(contentHTML);

                if (contentHTML.trim() === '' || contentHTML === '<p><br></p>') {
                    e.preventDefault();
                    alert('Article Content cannot be empty.');
                }
            });
        });
    </script>
@endpush