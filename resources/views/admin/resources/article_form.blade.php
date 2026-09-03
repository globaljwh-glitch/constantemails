@extends('admin.layouts.app')

@section('title', isset($article) ? 'Edit Article | Constant Emails' : 'Create Article | Constant Emails')

@push('styles')
    <!-- Summernote CDN -->
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
            <h3>{{ isset($article) ? 'Edit Article' : 'Add New Article' }}</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="{{ route('resource-articles.index') }}">Resources</a></li>
                    <li class="active"><a href="#">{{ isset($article) ? 'Edit' : 'Create' }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Validation Errors -->
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
                        action="{{ isset($article) ? route('resource-articles.update', $article->id) : route('resource-articles.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($article)) @method('PUT') @endif

                        <div class="row">
                            <!-- Category Select -->
                            <div class="col-md-6 mb-4">
                                <label for="category_id">Category Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-menu-list"></i></span></div>
                                    <select
                                        class="form-control form-control-rounded-right custom-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                        <option value="" disabled {{ old('category_id', $article->category_id ?? '') == '' ? 'selected' : '' }}>----Select----</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Article Name -->
                            <div class="col-md-6 mb-4">
                                <label for="name">Article Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-notes"></i></span></div>
                                    <input type="text" id="name" name="name"
                                        class="form-control form-control-rounded-right @error('name') is-invalid @enderror"
                                        placeholder="Enter article name..." value="{{ old('name', $article->name ?? '') }}"
                                        required>
                                </div>
                            </div>

                            <!-- Article Description -->
                            <div class="col-md-12 mb-4">
                                <label for="description">Article Description <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-edit-3"></i></span></div>
                                    <input type="text" id="description" name="description"
                                        class="form-control form-control-rounded-right @error('description') is-invalid @enderror"
                                        placeholder="Brief summary of the article..."
                                        value="{{ old('description', $article->description ?? '') }}" required>
                                </div>
                            </div>

                            <!-- Thumbnail Upload -->
                            <div class="col-md-6 mb-4">
                                <label for="thumbnail">Article Thumb <small>(GIF, JPG or PNG Only)</small>
                                    @if(!isset($article)) <span class="text-danger">*</span> @endif
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-picture"></i></span></div>
                                    <input type="file" id="thumbnail" name="thumbnail"
                                        class="form-control-file form-control form-control-rounded-right pt-2 @error('thumbnail') is-invalid @enderror"
                                        accept="image/png, image/gif, image/jpeg" {{ isset($article) ? '' : 'required' }}>
                                </div>
                                @if(isset($article) && $article->thumbnail)
                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-1">Current Thumbnail:</small>
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumb"
                                            style="height: 60px; border-radius: 4px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label for="status">Status</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-power-button"></i></span></div>
                                    <select
                                        class="form-control form-control-rounded-right custom-select @error('status') is-invalid @enderror"
                                        id="status" name="status">
                                        <option value="Active" {{ old('status', $article->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Deactive" {{ old('status', $article->status ?? '') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Summernote Click-to-Edit Area -->
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

                            <!-- Form Actions -->
                            <div class="col-md-12 text-right">
                                <a href="{{ route('resource-articles.index') }}"
                                    class="btn btn-dark btn-rounded mr-2">Cancel</a>
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
    <!-- Summernote JS CDN -->
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