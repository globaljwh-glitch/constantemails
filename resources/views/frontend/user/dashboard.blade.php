@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Accounts Details</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contentContainer">
  <div class="container">
  <div class="">
     
    <div class="row">
      <div class="col-lg-3 col-md-4">
  <div class="settingSection">
    <h2 class="text-white redBg mb-0">Main Menu</h2>
    <ul class="myaccountList">
      <li>
        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne"> <a href="my_account.html" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">My Account <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-minus" aria-hidden="true"></i></a> </div>
            <div id="collapseOne"  aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <ul>
                  <li><a href="my_account.html" class="">My Account</a></li>
                  <li><a href="account_details.html" class="">Edit your Contact and Billing Information</a></li>
                  <li><a href="change_password.html" class="">Change your Password</a></li>
                  <li><a href="upgrade_package.html" class="">Upgrade My Package</a></li>
                  <li><a href="payments.html" class="">Check payment history</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li>
        <a href="import.html" class="">Import Contact from database</a>
      </li>
      <li><a href="bad_email.html" class="">Bad Contacts Report</a></li>
      <li><a href="email_details.html" class="">Create and Emails/Email Campaign</a></li>
      <li><a href="email_stats.html" class="">Create Email History/Statistics</a></li>
      <li><a href="saved_template.html" class="">Manage Custom Templates</a></li>
      <li><a href="autoresponders.html" class="">My Auto Responders</a></li>
      <li><a href="add_autoresponder.html" class="<">Add an Auto Responder </a></li>
      <li><a href="gallery.html" class="activeclass">My Image Gallery</a></li>
      <li><a href="list_contact_groups.html">Manage your Contact List</a></li>
      <li>
        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne"> <a href="my_account.html" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapseOne" class="collapsed">Contacts List<i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-minus" aria-hidden="true"></i></a> </div>
            <div id="collapsetwo"  aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <ul >
                  <li><a href="list_contact_groups.html" class="">Manage your Contact List</a></li>
                  <li><a href="add_group.html" class="">Add/Create a Group</a></li>
                  <li><a  href="import.html" class="activeclass">Add Contacts</a></li>
                  <li><a  href="assign_contacts.html" class="">Assign Contacts you've added to existing Contact Groups</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li><a href="join_mailing_list.html" class="activeclass">Join Mailing List code</a></li>
      <li><a href="referral.html" class="activeclass">Refer a friend</a></li>


    </ul>
  </div>
  </div>

  <style type="text/css">
    .activeclass {
    background-color: #e62d29;
    color: #ffffff !important;
}
.contactForm input[type="radio"]{
height: 15px !important;
  }
  </style>
      <div class="col-lg-9 col-md-8">
        <div class="acoountRightSection">
          <div class="row">
            <div class="col-lg-12">
              <div class="borderBottom">
                <h2>My Account</h2>
                <p align="center"><font size="3" color="red">The changes you made have been succesfully saved!.<br></font></p>
              </div>
            </div>
          </div>
          <p class='mt-4'> You have the unlimited package!</p>
          <p class='mt-4'>You have ". $only_mail ." contact to be Uploaded. <a href='upgrade_package.html' class='linkButton'>Add more emails?</a> </p>
           <p>You have used "10"% of your "8000"MB image gallery space</p>
           <p>You have used 0MB of your 5MB image gallery space <a href='gallery.html' class='linkButton'>Upload images?</a></p>
            
          
          
          <div class="accountInfo">
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Name</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">First_name last_name</div>
              </div>
            </div>
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Company/Organization:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">company_name</div>
              </div>
            </div>
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Address:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Phone Number:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Fax Number:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>City/Town:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>State/Providence:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Country:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Zip/Postal Code:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            <div class="list borderBottom">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6"><strong>Package Type:</strong></div>
                <div class="col-lg-9 col-md-6 col-sm-6">Sample</div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection