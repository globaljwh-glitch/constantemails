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
                        <li><a href="{{ route('user.groups.index') }}" class="{{ request()->routeIs('user.groups.index') ? 'activeclass' : '' }}">Manage your Contact List</a></li>
                        <li><a href="{{ route('user.groups.create') }}" class="{{ request()->routeIs('user.groups.create') ? 'activeclass' : '' }}">Add/Create a Group</a></li>
                        <li><a href="{{ route('user.contacts.import') }}" class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}">Add Contacts</a></li>
                        <li><a href="assign_contacts.html" class="">Assign Contacts you've added to existing Contact Groups</a></li>
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