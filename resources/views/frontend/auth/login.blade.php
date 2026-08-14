@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')

<section class="contentContainer loginForm">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-5">
        <h2>Login to Account</h2>

          <p align=""><font color="#FF0000">get message</font></p>

        <p>Enter your email and password to login in your account.</p>
        <div class="contactForm pt-2">
           <form method="post" name="login" action="login.html" onSubmit="return Validate(this.form)">
          <div class="row">
            <div class="col-lg-12">
              <input type="text" name="username" value="" placeholder="Username" class="">
            </div>
            <div class="col-lg-12">
              <input type="password" name="pwd" value="" placeholder="Password" class="">
            </div>
            <div class="col-lg-12">
              
                  <input type="checkbox" value="1" class="checkbox" id="rememberMe" name="rememberMe" checked>

              <label for="rememberMe"> Remember My Login</label>
              <div class="clearfix"></div>
            </div>
            <div class="col-sm-4 col-lg-4">
              <input type="submit" value="Login" name="action_x" class="submitButton mb-0">
            </div>

            <div class="col-sm-8 col-lg-8">
              <div class="forgot"><a href="forget_password.html">Forgot Username or Password?</a></div>
            </div>
            <div class="col-lg-12">
              <div class="createAccount text-left">Need a Constant Email account? <a href="registration.html">Create an account</a></div>
            </div>
          </div>
        </form>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-7">
        <div class="imageThumb text-right"><img src="images/login-thumb.jpg" alt="" class=""></div>
      </div>
    </div>
  </div>
</section>

@endsection