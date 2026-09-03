@extends('admin.layouts.app')

@section('title', isset($template) ? 'Edit Template | Constant Emails' : 'Create Template | Constant Emails')

@push('styles')
    <!-- SUMMERNOTE CDN -->
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
            <h3>{{ isset($template) ? 'Edit Template' : 'Add New Template' }}</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="{{ route('templates.index') }}">Templates</a></li>
                    <li class="active"><a href="#">{{ isset($template) ? 'Edit' : 'Create' }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Template Details</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <form id="templateForm"
                        action="{{ isset($template) ? route('templates.update', $template->id) : route('templates.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($template))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Category Select -->
                            <div class="col-md-6 mb-4">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control custom-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="" disabled {{ old('category_id', $template->category_id ?? '') == '' ? 'selected' : '' }}>----Select----</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $template->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Template Name -->
                            <div class="col-md-6 mb-4">
                                <label for="name">Template Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter template name..." value="{{ old('name', $template->name ?? '') }}"
                                    required>
                            </div>

                            <!-- Thumbnail Upload -->
                            <div class="col-md-6 mb-4">
                                <label for="thumbnail">Thumbnail <small>(GIF, JPG or PNG. Min 140x200px)</small>
                                    @if(!isset($template)) <span class="text-danger">*</span> @endif
                                </label>
                                <input type="file" id="thumbnail" name="thumbnail"
                                    class="form-control-file @error('thumbnail') is-invalid @enderror"
                                    accept="image/png, image/gif, image/jpeg" {{ isset($template) ? '' : 'required' }}>
                                @if(isset($template) && $template->thumbnail)
                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-1">Current Thumbnail:</small>
                                        <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="thumb"
                                            style="height: 60px; border-radius: 4px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label for="status">Status</label>
                                <select class="form-control custom-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="Active" {{ old('status', $template->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Deactive" {{ old('status', $template->status ?? '') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </div>

                            <!-- Summernote Click-to-Edit Area -->
                            <div class="col-md-12 mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <label>Template Content <span class="text-danger">*</span></label>
                                    <div class="text-right">
                                        <button type="button" id="editEditor" class="btn btn-primary btn-rounded btn-sm"><i
                                                class="flaticon-edit-fill-2 position-left"></i> Edit Content</button>
                                        <button type="button" id="saveEditor" class="btn btn-success btn-rounded btn-sm"><i
                                                class="flaticon-fill-tick position-left"></i> Lock Content</button>
                                    </div>
                                </div>

                                <div class="click2edit editor-container">
                                    {!! old('content', $template->content ?? '<p>Start building your template here...</p>') !!}
                                </div>

                                <input type="hidden" name="content" id="hiddenContent">
                            </div>

                            <!-- Form Actions -->
                            <div class="col-md-12 text-right">
                                <a href="{{ route('templates.index') }}" class="btn btn-dark btn-rounded mr-2">Cancel</a>
                                <button type="submit" class="btn btn-gradient-warning btn-rounded">
                                    {{ isset($template) ? 'Update Template' : 'Save Template' }}
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
            $('#templateForm').on('submit', function (e) {
                if ($('.click2edit').hasClass('summernote-active') || $('.note-editor').length) {
                    $('.click2edit').summernote('destroy');
                }

                let contentHTML = $('.click2edit').html();
                $('#hiddenContent').val(contentHTML);

                if (contentHTML.trim() === '' || contentHTML === '<p><br></p>') {
                    e.preventDefault();
                    alert('Template Content cannot be empty.');
                }
            });
        });
    </script>
@endpush