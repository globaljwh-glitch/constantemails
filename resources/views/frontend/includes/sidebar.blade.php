<!-- <div class="settingSection">
          <h2 class="text-white redBg mb-0">Main Menu</h2>
          <ul class="myaccountList">
            <li>
              <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne"> <a href="/user/dashboard" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">My Account <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-minus" aria-hidden="true"></i></a> </div>
                  <div id="collapseOne"  aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <ul>
                        <li><a href="/user/dashboard" class="{{ request()->is('user/dashboard') ? 'activeclass' : '' }}">My Account</a></li>
                        <li><a href="#" class="">Edit your Contact and Billing Information</a></li>
                        <li><a href="#" class="">Change your Password</a></li>
                        <li><a href="#" class="">Upgrade My Package</a></li>
                        <li><a href="#" class="">Check payment history</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <a href="#" class="">Import Contact from database</a>
            </li>
            <li><a href="#" class="">Bad Contacts Report</a></li>
            <li>
              <a href="{{ route('user.campaigns.create') }}"
                class="{{ request()->routeIs('user.campaigns.*') ? 'activeclass' : '' }}">
                  Create and Emails/Email Campaign
              </a>
            </li>
            <li><a href="#" class="">Create Email History/Statistics</a></li>
            <li><a href="#" class="">Manage Custom Templates</a></li>
            <li><a href="#" class="">My Auto Responders</a></li>
            <li><a href="#" class="">Add an Auto Responder </a></li>
            <li><a href="#" class="">My Image Gallery</a></li>
            <li><a href="#">Manage your Contact List</a></li>
            <li>
              <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne"> <a href="/user/dashboard" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapseOne" class="collapsed">Contacts List<i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-minus" aria-hidden="true"></i></a> </div>
                  <div id="collapsetwo"  aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <ul >
                        <li><a href="{{ route('user.groups.index') }}" class="{{ request()->routeIs('user.groups.index') ? 'activeclass' : '' }}">Manage your Contact List</a></li>
                        <li><a href="{{ route('user.groups.create') }}" class="{{ request()->routeIs('user.groups.create') ? 'activeclass' : '' }}">Add/Create a Group</a></li>
                        <li><a href="{{ route('user.contacts.import') }}" class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}">Add Contacts</a></li>
                        <li><a href="#" class="">Assign Contacts you've added to existing Contact Groups</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li><a href="#" class="">Join Mailing List code</a></li>
            <li><a href="#" class="">Refer a friend</a></li>


          </ul>
        </div> -->












        <div class="settingSection">

    <h2 class="text-white redBg mb-0">
        Main Menu
    </h2>

    <ul class="myaccountList">

        {{-- =====================================================
             MY ACCOUNT
        ====================================================== --}}
        <li class="account-menu-item">

            <div class="menu-toggle-header" id="accountMenuHeader" style="display: block;">

                <span>My Account</span>

                <i class="fa fa-minus menu-toggle-icon"
                   id="accountMenuIcon"
                   aria-hidden="true"></i>

            </div>


            <div class="menu-toggle-content" id="accountMenuContent">

                <ul>

                    <li>
                        <a href="{{ route('user.dashboard') }}"
                           class="{{ request()->routeIs('user.dashboard') ? 'activeclass' : '' }}">
                            My Account
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.account.profile') }}" 
                        class="{{ request()->routeIs('user.account.profile') ? 'activeclass' : '' }}">
                            Edit your Contact and Billing Information
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.account.password') }}"
                          class="{{ request()->routeIs('user.account.password') ? 'activeclass' : '' }}">
                            Change your Password
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.account.upgrade') }}"
                          class="{{ request()->routeIs('user.account.upgrade') ? 'activeclass' : '' }}">
                            Upgrade My Package
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.account.payment.history') }}"
                          class="{{ request()->routeIs('user.account.payment.history') ? 'activeclass' : '' }}">
                            Check Payment History
                        </a>
                    </li>

                </ul>

            </div>

        </li>


        {{-- =====================================================
             NORMAL MENU ITEMS
        ====================================================== --}}

        <li>
            <a href="{{ route('user.contacts.import') }}"
                class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}">
                Import Contact from database
            </a>
        </li>

        <li>
            <a href="{{ route('user.contacts.bad-report') }}"
              class="{{ request()->routeIs('user.contacts.bad-report*') ? 'activeclass' : '' }}">
                Bad Contacts Report
            </a>
        </li>


        <li>
            <a href="{{ route('user.campaigns.create') }}"
               class="{{ request()->routeIs('user.campaigns.*') ? 'activeclass' : '' }}">
                Create and Emails/Email Campaign
            </a>
        </li>

        <li>
            <a href="{{ route('user.email-stats.index') }}" class="{{ request()->routeIs('user.email-stats.index') ? 'activeclass' : '' }}">
                Create Email History/Statistics
            </a>
        </li>

        <li>
            <a href="{{ route('user.saved-templates.index') }}"
              class="{{ request()->routeIs('user.saved-templates.*') ? 'activeclass' : '' }}">
                Manage Custom Templates
            </a>
        </li>

        <li>
            <a href="{{ route('user.autoresponders.index') }}"
              class="{{ request()->routeIs('user.autoresponders.index') ? 'activeclass' : '' }}">
                My Auto Responders
            </a>
        </li>

        <li>
            <a href="{{ route('user.autoresponders.create') }}" class="{{ request()->routeIs('user.autoresponders.create') ? 'activeclass' : '' }}">
                Add an Auto Responder
            </a>
        </li>

        <li>
            <a href="{{ route('user.image-gallery.index') }}"
              class="{{ request()->routeIs('user.image-gallery.*') ? 'activeclass' : '' }}">
                My Image Gallery
            </a>
        </li>


        {{-- =====================================================
             CONTACTS LIST
        ====================================================== --}}
        <li class="account-menu-item">

            <div class="menu-toggle-header"
                 id="contactsMenuHeader" style="display: block;">

                <span>Contacts List</span>

                <i class="fa fa-minus menu-toggle-icon"
                   id="contactsMenuIcon"
                   aria-hidden="true"></i>

            </div>


            <div class="menu-toggle-content"
                 id="contactsMenuContent">

                <ul>

                    <li>
                        <a href="{{ route('user.groups.index') }}"
                           class="{{ request()->routeIs('user.groups.index') ? 'activeclass' : '' }}">
                            Manage your Contact List
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.groups.create') }}"
                           class="{{ request()->routeIs('user.groups.create') ? 'activeclass' : '' }}">
                            Add/Create a Group
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.contacts.import') }}"
                           class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}">
                            Add Contacts
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.contacts.assign') }}" class="{{ request()->routeIs('user.contacts.assign') ? 'activeclass' : '' }}">
                            Assign Contacts you've added to existing Contact Groups
                        </a>
                    </li>

                </ul>

            </div>

        </li>


        {{-- =====================================================
             OTHER MENU ITEMS
        ====================================================== --}}

        <li>
            <a href="{{ route('user.mailing-list.store') }}" class="{{ request()->routeIs('user.mailing-list') ? 'activeclass' : '' }}">
                Join Mailing List code
            </a>
        </li>

        <li>
            <a href="{{ route('user.referral') }}"
              class="{{ request()->routeIs('user.referral') ? 'activeclass' : '' }}">
                Refer a friend
            </a>
        </li>

    </ul>

</div>


{{-- =========================================================
     MENU CSS
========================================================= --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | Menu Toggle Header
    |--------------------------------------------------------------------------
    */

    .menu-toggle-header {
        position: relative;
        display: block;
        width: 100%;
        padding: 15px 18px;
        cursor: pointer;

        font-size: 20px;
        line-height: 1.4;
        color: #111;

        border-bottom: 1px solid #ddd;

        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Icon
    |--------------------------------------------------------------------------
    */

    .menu-toggle-icon {
        position: absolute;
        right: 18px;
        top: 50%;

        transform: translateY(-50%);

        font-size: 20px;
        line-height: 1;

        color: #111;
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Menu
    |--------------------------------------------------------------------------
    */

    /* .menu-toggle-content {
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;

        box-sizing: border-box;
    } */

    .menu-toggle-content {
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
        background: #f4f6f8;
        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Menu UL
    |--------------------------------------------------------------------------
    */

    /* .menu-toggle-content > ul {
        width: 100%;

        padding: 0 !important;
        margin: 0 !important;

        list-style: none;
    } */

    .menu-toggle-content > ul {
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
        list-style: none;
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Menu LI
    |--------------------------------------------------------------------------
    */

    /* .menu-toggle-content > ul > li {
        width: 100%;

        padding: 0 !important;
        margin: 0 !important;

        list-style: none;
    } */

    .menu-toggle-content > ul > li {
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
        list-style: none;
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Menu Links
    |--------------------------------------------------------------------------
    */

    /* .menu-toggle-content > ul > li > a {
        display: block;

        width: 100%;

        padding: 15px 18px;
        margin: 0 !important;

        box-sizing: border-box;

        text-decoration: none;
    } */

    .menu-toggle-content > ul > li > a {
        display: block;
        width: 100%;
        padding: 14px 16px;
        margin: 0 !important;

        box-sizing: border-box;

        background: #f4f6f8;
        color: #222;

        border-bottom: 1px solid #e2e5e8;

        text-decoration: none;
    }

    /* Hover */
    .menu-toggle-content > ul > li > a:hover {
        background: #e8ecef;
        color: #222;
    }

    /*
    |--------------------------------------------------------------------------
    | Active Sub Menu Link
    |--------------------------------------------------------------------------
    */

    /* .menu-toggle-content > ul > li > a.activeclass {
        display: block;

        width: 100%;

        padding: 15px 18px;
        margin: 0 !important;

        box-sizing: border-box;

        background-color: #ed2929;
        color: #fff;

        text-decoration: none;
    } */

    .menu-toggle-content > ul > li > a.activeclass {
        display: block;
        width: 100%;

        padding: 14px 16px;
        margin: 0 !important;

        box-sizing: border-box;

        background: #ed2929;
        color: #fff;

        border-bottom: 1px solid #ed2929;
    }


    /*
    |--------------------------------------------------------------------------
    | Make parent LI full width
    |--------------------------------------------------------------------------
    */

    .account-menu-item {
        width: 100% !important;

        padding: 0 !important;
        margin: 0 !important;

        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | Remove possible Bootstrap card styling
    |--------------------------------------------------------------------------
    */

    .account-menu-item .card,
    .account-menu-item .card-header,
    .account-menu-item .card-body {
        border: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        background: transparent !important;
    }

</style>


{{-- =========================================================
     MENU JAVASCRIPT
========================================================= --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | MY ACCOUNT
    | Open by default
    |--------------------------------------------------------------------------
    */

    $('#accountMenuHeader').on('click', function () {

        $('#accountMenuContent').stop(true, true).slideToggle(200, function () {

            if ($(this).is(':visible')) {

                $('#accountMenuIcon')
                    .removeClass('fa-plus')
                    .addClass('fa-minus');

            } else {

                $('#accountMenuIcon')
                    .removeClass('fa-minus')
                    .addClass('fa-plus');

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CONTACTS LIST
    | Closed by default
    |--------------------------------------------------------------------------
    */

    $('#contactsMenuHeader').on('click', function () {

        $('#contactsMenuContent').stop(true, true).slideToggle(200, function () {

            if ($(this).is(':visible')) {

                $('#contactsMenuIcon')
                    .removeClass('fa-plus')
                    .addClass('fa-minus');

            } else {

                $('#contactsMenuIcon')
                    .removeClass('fa-minus')
                    .addClass('fa-plus');

            }

        });

    });


});

</script>