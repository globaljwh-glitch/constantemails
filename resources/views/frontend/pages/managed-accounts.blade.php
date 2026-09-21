@extends('frontend.layouts.app')

@section('title', 'Managed Accounts')

@section('content')

{{-- =========================================
     Banner
========================================= --}}
<section class="homeBanner innerBanner">

    <div class="container">

        <div class="row">

            <div class="col-lg-10 marginAuto">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <h1>Managed Accounts</h1>

                        <p>
                            If you do not see your desired amount of contacts
                            reachable on our listed price packages, please feel
                            free to contact us for a personalized quote.
                        </p>

                        <div class="header-button-container">

                            <a
                                href="{{ route('register') }}"
                                class="custom-btn1 orangeBg"
                            >
                                Try For Free
                            </a>

                            <a
                                href="{{ route('pricing') }}"
                                class="custom-btn1 transparent-btn"
                            >
                                Pricing Plans
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================
     High Volume Sender
========================================= --}}
<section class="contentContainer">

    <div class="container">

        <div class="row align-items-center">

            {{-- Image --}}
            <div class="col-md-4 col-lg-5">

                <div class="imageThumb">

                    <img
                        src="{{ asset('assets/frontend/images/mangae-account-thumb.jpg') }}"
                        alt="Managed Accounts"
                        class="imgResponsive"
                    >

                </div>

            </div>


            {{-- Content --}}
            <div class="col-md-8 col-lg-7">

                <div class="middleContentOuter">

                    <div class="verticalMiddle featureContentRight">

                        <h2>
                            Are you a High Volume Sender?
                        </h2>

                        <p>
                            With each new email sent, more and more people are
                            receiving your message! Constant Emails offers a
                            specifically designed mass-emailing option for
                            businesses with large-scale and/or complex email
                            marketing requirements.
                        </p>

                        <p class="mb-0">
                            Allow Constant Emails to help you make the most out
                            of your email marketing campaigns through the use of
                            our flexible packaged plans. From one to one thousand
                            emails, we provide the tools you need to manage your
                            email campaigns effectively.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================
     Customized Deliverability Strategy
========================================= --}}
<section class="contentContainer background-01">

    <div class="container">

        <div class="row align-items-center">

            {{-- Image --}}
            <div class="col-md-12 col-lg-6">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <div class="imageThumb">

                            <img
                                src="{{ asset('assets/frontend/images/thumb-05.png') }}"
                                alt="Customized Deliverability Strategy"
                                class="imgResponsive"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- Content --}}
            <div class="col-md-12 col-lg-6">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <h2>
                            Customized Deliverability Strategy
                        </h2>

                        <p>
                            Achieve optimal deliverability with a strategy
                            designed specifically for your use case.
                        </p>

                        <p>
                            We start by evaluating your delivery challenges,
                            objectives and the intricacies of your email
                            program. From there, our email experts create a
                            custom deliverability plan to improve your email
                            performance and increase the ROI of your email
                            program.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================
     Benefits
========================================= --}}
<section class="contentContainer gradient-bg">

    <div class="container">

        <div class="row align-items-center">

            {{-- Content --}}
            <div class="col-md-12 col-lg-7 order-lg-1 order-md-2 order-2">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <h2>
                            Benefits of Constant Emails
                        </h2>

                        <ul class="listing02">

                            <li>
                                <a href="#">
                                    Create your own Campaigns
                                </a>

                                <br>

                                Compose and send out professional-looking
                                email marketing campaigns.
                            </li>


                            <li>
                                <a href="#">
                                    Manage unlimited groups &amp; lists
                                </a>

                                <br>

                                Build multiple group lists of qualified contacts.
                            </li>


                            <li>
                                <a href="#">
                                    Import from popular databases
                                </a>

                                <br>

                                Easily add contacts from MySQL, MSSQL,
                                Microsoft Excel and Microsoft Access databases.
                            </li>


                            <li>
                                <a href="#">
                                    Get detailed Reports
                                </a>

                                <br>

                                Track who receives and opens your emails.
                            </li>


                            <li>
                                <a href="#">
                                    Create your own mailing templates
                                </a>

                                <br>

                                Custom-made templates let your branding
                                shine through.
                            </li>


                            <li>
                                <a href="#">
                                    Get free coaching and support
                                </a>

                                <br>

                                We are here to help you with anything
                                you may need.
                            </li>

                        </ul>

                    </div>

                </div>

            </div>


            {{-- Image --}}
            <div class="col-md-12 col-lg-5 order-lg-2 order-md-1 order-1">

                <div class="middleContentOuter">

                    <div class="verticalMiddle">

                        <div class="imageThumb text-right">

                            <img
                                src="{{ asset('assets/frontend/images/thumb-04.jpg') }}"
                                alt="Constant Emails Benefits"
                                class="imgResponsive"
                            >

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection