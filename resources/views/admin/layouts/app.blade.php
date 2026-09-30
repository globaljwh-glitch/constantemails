<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- Added CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Default | Constant Email')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/assets/img/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/admin/assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/admin/assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin/assets/img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/admin/assets/img/site.webmanifest') }}">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/assets/css/support-chat.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/plugins/maps/vector/jvector/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/admin/plugins/charts/chartist/chartist.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/assets/css/default-dashboard/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @stack('styles')
    <style>
        /* Target the specific file input using its ID */
        #thumbnail::file-selector-button {
            background-color: #0d6efd;
            /* Bootstrap blue */
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.2s;
        }

        /* Make it slightly darker when you hover over it */
        #thumbnail::file-selector-button:hover {
            background-color: #0b5ed7;
        }
    </style>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
</head>


<body class="default-sidebar">

    @include('admin.layouts.header')

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>

        @include('admin.layouts.sidebar')

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    @include('admin.layouts.chat')

    @include('admin.layouts.footer')

    @include('admin.layouts.control_sidebar')

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{  asset('assets/admin/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{  asset('assets/admin/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{  asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{  asset('assets/admin/assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function () {
            App.init();
        });
    </script>
    <script src="{{  asset('assets/admin/assets/js/custom.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/charts/chartist/chartist.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/maps/vector/jvector/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script
        src="{{  asset('assets/admin/plugins/maps/vector/jvector/worldmap_script/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/calendar/pignose/moment.latest.min.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/calendar/pignose/pignose.calendar.js') }}"></script>
    <script src="{{  asset('assets/admin/plugins/progressbar/progressbar.min.js') }}"></script>
    <script src="{{  asset('assets/admin/assets/js/default-dashboard/default-custom.js') }}"></script>
    <script src="{{  asset('assets/admin/assets/js/support-chat.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @stack('scripts')
    <script>
        $(document).ready(function () {
            var placeholderText = '<p>Start building your template here...</p>';

            // When the "Edit Content" button is clicked
            $('#editEditor').on('click', function () {
                var $editor = $('.click2edit');

                // If the current content is exactly the placeholder, empty it
                if ($editor.html().trim() === placeholderText) {
                    $editor.html('');

                    // Note: If you are using Summernote, uncomment the line below instead:
                    // $editor.summernote('code', ''); 
                }
            });

            // Optional: Also clear it if they click directly inside the editor box
            $('.click2edit').on('click', function () {
                if ($(this).html().trim() === placeholderText) {
                    $(this).html('');
                    // $(this).summernote('code', ''); // Uncomment if using Summernote
                }
            });
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>