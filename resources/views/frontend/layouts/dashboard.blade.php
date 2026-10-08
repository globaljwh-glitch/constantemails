@extends('frontend.layouts.app')

@section('content')

<section class="contentContainer">
    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>

            <div class="col-lg-9 col-md-8">
                @if(request()->routeIs('user.campaigns.index'))

                    @include('frontend.includes.flash-message')

                @else

                    <div class="acoountRightSection {{ request()->routeIs('user.groups.contacts.index') ? 'contactAccountSection' : '' }}">
                        @include('frontend.includes.flash-message')
                    </div>

                @endif
                
                @yield('dashboard-content')
            </div>

        </div>

    </div>
</section>

@endsection