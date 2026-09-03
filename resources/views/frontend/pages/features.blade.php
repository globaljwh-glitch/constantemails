@extends('frontend.layouts.app')

@section('title', 'Features')

@section('content')

<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Features</h1>
            <p>Our methods to create powerful email campaigns may be quick and simple, but the results are powerful and professional! Below are the features we provide to make your emails shine.</p>
            <div class="header-button-container"> <a href="registration.html" class="custom-btn1 orangeBg">Try For Free</a> <a href="pricing.html" class="custom-btn1 transparent-btn">Pricing Plans</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contentContainer">
  <div class="container">
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-01.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentRight">
                <h2>Security</h2>
                <p>Our built in 256-bit data encryption ensures that your data stays secure! Not even out admin’s will have access to your mailing lists. Partnering with Authorize.net and Secure Sockets Layer (SSL), we can promise that your sensitive information stays secure! Any credit card information that you provide is not stored to our website or our server, guaranteeing that your identity and your company stays secure.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3 order-lg-2 order-md-2 order-sm-1">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-02.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9 order-md-1 order-sm-2">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentLeft">
                <h2>Importing Your Contacts</h2>
                <p>There are two ways in which you can upload your contacts: either by importing them from your databases or by entering them manually. Importing your contacts through a file is the easiest way to enter mass amounts of clients. You can readily import your existing lists using CSV, Microsoft Access*, Microsoft Excel 97-2003 (.xls), and Microsoft Excell 2007-Present (.xlsx). A more in depth instruction on how to upload from your data bases can be found on our FAQ’s section!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-03.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentRight">
                <h2>List Management</h2>
                <p>Our list management tools help you keep your contacts organized!</p>
                <ul class="listing01">
                  <li>Compile lists of similar contacts grouped by interests, demographics, behavior, or any customized grouping you desire.</li>
                  <li>Send out marketing campaigns to contacts with the click of a button.</li>
                  <li>Create and store as many client lists as needed.</li>
                  <li>Expand your emailing lists with our sign-up form. Place it on your website and watch as new contacts are added to your lists automatically.</li>
                  <li>Clean out bounces and invalid addresses with our cleanup tools.</li>
                  <li>With our email validation system, purge invalid addresses from your lists before ever sending out an email.</li>
                  <li>Target your audience’s specific interests, locations, industries, and more.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3 order-lg-2 order-md-2 order-sm-1">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-04.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9 order-md-1 order-sm-2">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentLeft">
                <h2>Email Creation</h2>
                <p>Express your creativity with eye catching email campaigns! With our email editor you can: </p>
                <ul class="listing01">
                  <li>Specify what colors and fonts to use.</li>
                  <li>Choose from one of our professional templates to design your emails, or create your own with our custom template.</li>
                  <li>Preview all your emails before sending.</li>
                  <li>Upload important attachments to your emails as needed.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-05.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentRight">
                <h2>Manage your campaigns</h2>
                <ul class="listing01">
                  <li>Personalize your email campaigns with your company logo.</li>
                  <li>Style your emails to reflect your corporate image.</li>
                  <li>Program your emails to display your own “from name” so that your recipients recognize you as the sender.</li>
                  <li>Expand the reach of your campaign with our “forward on to a friend” option.</li>
                  <li>Direct traffic to your website by adding links to it in your emails. </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock">
      <div class="row">
        <div class="col-md-4 col-lg-3 order-lg-2 order-md-2 order-sm-1">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-06.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9 order-md-1 order-sm-2">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentLeft">
                <h2>Deliverability</h2>
                <p>Rely on us to deliver your emails with high success rate. We take many precautions to make sure your emails make it to your customer’s inboxes, rather than being classified as spam. With our email address validation system, we can verify email addresses on your list before you ever send a single email! With this, we ensure that fewer bounced emails receive your carefully crafted message.</p>
                <ul class="listing01">
                  <li>Schedule when you would like your email campaigns to be sent. Our system lets you specify specific dates and times for the future, so you don’t have to worry about scheduling them later.</li>
                  <li>Schedule marketing campaigns to go out on a recurring basis.</li>
                  <li>Arrange for auto responders and follow up emails to be sent in response to specific actions taken by your recipients. For example: opening your email, clicking on your link, making a transaction, etc. They can receive another email related to their action.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="featureBlock last">
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="imageThumb"><img src="{{ asset('assets/frontend/images/feature-thumb-07.jpg') }}" alt="" class="" /></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <div class="middleContentOuter">
            <div class="verticalMiddle">
              <div class="featureContentRight">
                <h2>Statistics / Reports</h2>
                <p>Uncover results, fast and easy!</p>
                <ul class="listing01">
                  <li>We offer complete message reporting: including information on opens and click-thru rates.</li>
                  <li>View detailed statistic about email deliveries, opens, bounces, unsubscribes, and click-thru’s.</li>
                  <li>Track recipients that clicked on embedded links.</li>
                  <li>Track how many recipients forwarded your emails.</li>
                </ul>
                <p>Our reports can easily be exported into Microsoft excel spread sheets, text files, and word documents so you can easily compare your reports! All your reports and statistics provided by us are archived so you can monitor the growth of your company.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection