@extends('frontend.layouts.app')

@section('title', 'Our Templates')

@section('content')

<style>
    .templateSection img {
        height: 283px;
        width: 248px;
        object-fit: cover;
    }

    .templateSection {
        margin-bottom: 30px;
    }
</style>

<section class="homeBanner innerBanner">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 marginAuto">
                <div class="middleContentOuter">
                    <div class="verticalMiddle">

                        <h1>Our Templates</h1>

                        <p>
                            Choose from a wide verity of templates below!
                            We offer pre-formatted templates that only need
                            your ideas and pictures to be sent out! With just
                            a quick click of a few buttons, send a personalized
                            pamphlet, nuanced newsletter, or even an eye-catching card!
                        </p>

                        <div class="header-button-container">

                            <!-- <a href="{{ route('register') }}"
                               class="custom-btn1 orangeBg">
                                Try For Free
                            </a> -->
                            @if(auth()->check())
                                <a href="{{ route('user.dashboard') }}" class="custom-btn1 orangeBg">
                                    Try For Free
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="custom-btn1 orangeBg">
                                    Try For Free
                                </a>
                            @endif

                            <a href="{{ route('pricing') }}"
                               class="custom-btn1 transparent-btn">
                                Pricing Plans
                            </a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contentContainer contentContainer02">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <p>
                    Browse our library of templates, or create your own from scratch!
                    We provide the tools, you provide the text!
                    Professional templates accessible with our free subscription today.
                    Learn more about our platform packages here.
                </p>

                <p>
                    @if(auth()->check())
                        <a href="{{ route('user.dashboard') }}" class="text-orange">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="text-orange">
                            Register today
                        </a>
                    @endif
                    <!-- <a href="{{ route('register') }}" class="text-orange">
                        Register today
                    </a> -->
                    and start using all of our features for <b>FREE</b>!
                </p>

            </div>

        </div>

    </div>

</section>


<section class="contentContainer gradient-bg">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="templatesBlock">

                    {{-- ================================
                         TEMPLATE CATEGORY TABS
                    ================================= --}}

                    <ul id="templatesTabs" class="nav nav-tabs">

                        @foreach($categories as $key => $category)

                            <li class="nav-item">

                                <a
                                    class="nav-link {{ $key === 0 ? 'active' : '' }}"
                                    data-toggle="tab"
                                    href="#category-{{ $category->id }}"
                                >
                                    {{ $category->name }}
                                </a>

                            </li>

                        @endforeach

                    </ul>


                    {{-- ================================
                         TEMPLATE CONTENT
                    ================================= --}}

                    <div class="tab-content">

                        @foreach($categories as $key => $category)

                            <div
                                id="category-{{ $category->id }}"
                                class="tab-pane {{ $key === 0 ? 'active' : 'fade' }}"
                            >

                                <div class="row">

                                    @forelse($category->templates as $template)

                                        <div class="col-sm-6 col-md-4 col-lg-3">

                                            <div class="templateSection">

                                                <a href="#">

                                                    <div class="templateThumb">

                                                        <img
                                                        src="{{ $template->thumbnail
                                                            ? asset('storage/' . $template->thumbnail)
                                                            : asset('assets/frontend/images/default-template.png') }}"
                                                            alt="{{ $template->name }}"
                                                            class="imgResponsive"
                                                        >

                                                    </div>

                                                    <div class="templateName">
                                                        {{ $template->name }}
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="col-lg-12">

                                            <p>
                                                No templates available in
                                                {{ $category->name }}.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection