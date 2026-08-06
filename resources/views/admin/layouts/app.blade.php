<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.head')

<body>

<div class="page-wrapper">

    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    <!-- <div class="page-content"> -->

        @yield('content')

    <!-- </div> -->

    @include('admin.layouts.footer')

</div>

@include('admin.layouts.scripts')

</body>
</html>