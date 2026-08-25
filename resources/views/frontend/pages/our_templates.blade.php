@extends('frontend.layouts.app')

@section('title', 'Our Templates')

@section('content')

<style type="text/css">
  .templateSection img {
    height: 283px;
    width: 248px;
}
</style>
<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Our Templates</h1>
            <p>Choose from a wide verity of templates below! We offer pre-formatted templates that only need your ideas and pictures to be sent out! With just a quick click of a few buttons, send a personalized pamphlet, nuanced newsletter, or even an eye-catching card!</p>
            <div class="header-button-container">
              <a href="{{ route('register') }}" class="custom-btn1 orangeBg">Try For Free</a>
              <a href="{{ route('pricing') }}" class="custom-btn1 transparent-btn">Pricing Plans</a>
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
        <p>Browse our library of templates, or create your own from scratch! We provide the tools, you provide the text!  Professional templets accessible with our free subscription today. Learn more about our platform packages here.</p>
            <a href="{{ route('register') }}" class="text-orange">Register today</a> and start using all of our features for <b>FREE</b>!
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
          <ul id="templatesTabs" class="nav nav-tabs">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#newsLetter">NewsLetter</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#invitations">Invitations</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#cards">Cards</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#promotions">Promotions</a> </li>
          </ul>
          <div class="tab-content">
            <div id="newsLetter" class="tab-pane active">
              <div class="row">
  
                        <div class=" col-sm-6 col-md-4 col-lg-3">
                          <div class="templateSection"> <a href="#">
                            <div class="templateThumb"><img src="#" alt="template#01" class="imgResponsive" /></div>
                            <div class="templateName">01</div>
                            </a> </div>
                        </div>
              </div>
            </div>
            <div id="invitations" class="tab-pane fade">
              <div class="row">

                    <div class=" col-sm-6 col-md-4 col-lg-3">
                      <div class="templateSection"> <a href="#">
                        <div class="templateThumb"><img src="#" alt="template#01" class="imgResponsive" /></div>
                        <div class="templateName">02</div>
                        </a> </div>
                    </div> 
              </div>
            </div>
            <div id="cards" class="tab-pane fade">
              <div class="row">

                  <div class=" col-sm-6 col-md-4 col-lg-3">
                    <div class="templateSection"> <a href="#">
                      <div class="templateThumb"><img src="#" alt="template#01" class="imgResponsive" /></div>
                      <div class="templateName">03</div>
                      </a> </div>
                  </div>
              </div>
            </div>
            <div id="promotions" class="tab-pane fade">
              <div class="row">
                      <div class=" col-sm-6 col-md-4 col-lg-3">
                        <div class="templateSection"> <a href="#">
                          <div class="templateThumb"><img src="#" alt="template#01" class="imgResponsive" /></div>
                          <div class="templateName">04</div>
                          </a> </div>
                      </div>
                
              </div>
            </div>
            <!--<div id="promotions" class="container tab-pane fade"><br></div>--> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection