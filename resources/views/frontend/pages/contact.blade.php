@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')

<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Contact Us</h1>
            <p>Here at Constant Emails, your questions are our first priority! Skilled marketers are standing by ready to assist you with your blossoming business’ questions and concerns. Our support team will get back you as soon as your inquires reach us!</p>
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
<section class="contentContainer">
  <div class="container">
  	<div class="row">
      <div class="col-lg-12">
      	 <p align="center"><span id="name_asterix" class="arial_12_000"></br>
      	 	<strong>Thank you for contacting us! </strong>

<br/><br/>Your questions and concerns are our first priority. <br/>We will get back to you promptly regarding your message – we try our best to answer most messages within 24 to 48 hours.</br></br></br>
</span></p> 


      </div>
    </div>
    <div class="contactForm">
      <div class="row">
        <div class="col-md-8 col-lg-8">
        	<form name="user" method="post" action="contact.html" onSubmit="return Validate(this.form)">
            <input type="hidden" value="recoveryPassword" name="moduleLoginAction">
	          <div class="row">
	          	<div class="col-md-6 col-lg-6"><input type="text" name="first_name" value="" placeholder="First Name" class=""></div>
	          	<div class="col-md-6 col-lg-6"><input type="text" name="last_name" value="" placeholder="Last Name" class=""></div>
	          	<div class="col-md-6 col-lg-6"><input type="email" name="email" value="" placeholder="Email" class=""></div>
	          	<div class="col-md-6 col-lg-6"><input type="text" name="organization" value="" placeholder="Organization" class=""></div>
	          	<div class="col-md-6 col-lg-6"><input type="text" name="phone" value="" placeholder="(Phone Number: Eg. xxxxxxxxxx)" class=""></div>
	          	<div class="col-md-12 col-lg-12"><textarea class="" name="comments" placeholder="Message"></textarea></div>
	            <div class="col-md-12 col-lg-12"><input type="submit" value="Submit" name="submit" class="submitButton mb-0"> </div>
	          </div>
	        </form>
        </div>
        <div class="col-md-4 col-col-lg-4">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d929791.0698853646!2d-75.1038233558096!3d40.050138907904106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c0fb959e00409f%3A0x2cd27b07f83f6d8d!2sNew%20Jersey%2C%20USA!5e0!3m2!1sen!2sin!4v1579256760371!5m2!1sen!2sin" width="100%" height="455" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        </div>
        
        
      </div>
    </div>
  </div>
</section>

@endsection