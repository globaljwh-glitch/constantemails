@extends('frontend.layouts.app')

@section('title', 'Resources')

@section('content')

<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Resources</h1>
            <p>Learn tips to help you send out better campaigns and achieve more success with email marketing.</p>
            <div class="header-button-container"> <a href="{{ route('register') }}" class="custom-btn1 orangeBg">Try For Free</a> <a href="{{ route('pricing') }}" class="custom-btn1 transparent-btn">Pricing Plans</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contentContainer">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <table width="100%" cellspacing="0" cellpadding="0" >
          <tbody>
            <tr>
              <td style="padding:0;">
                <ul class="listing02 resourceList">
                  <li>
                    <a href="" class="arial_13_c43e00">Email Marketing Best Practices</a><br/> 
                    Learn how to make your email marketing campaign the most successful that it can be.
                  </li>
                  <li>
                    <a href="" class="arial_13_c43e00">Email Marketing Terms</a><br/> 
                    Our list of common terms used in email marketing is available to help you understand the language.
                  </li>
                  <li>
                    <a href="" class="arial_13_c43e00">Email Marketing Tips</a><br/> 
                    Learn tips to help you send out better campaigns and achieve more success with email marketing. We have advice and techniques for growing your contact lists, increasing open and click-thru rates, and creating eye catching campaigns.
                  </li>
                  <li>
                    <a href="" class="arial_13_c43e00">FAQ’s (Frequently Asked Questions)</a><br/> 
                    Answers and quick "how-to" tips
                  </li>
                  <li>
                    <a href="" class="arial_13_c43e00">Videos</a><br/> 
                    Watch videos of experts giving advice on a range of topics, including how to help your small business
                  </li>
                </ul>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

@endsection