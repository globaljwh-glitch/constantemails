<!DOCTYPE html>
<html lang="en">

@include('frontend.partials.head')

<body>

@include('frontend.partials.header')

<main>
    @yield('content')
</main>

@include('frontend.partials.footer')

@include('frontend.partials.scripts')

@stack('scripts')

</body>
</html>