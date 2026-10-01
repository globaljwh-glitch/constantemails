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


        <div class="settingSection1">

            <ul class="myaccountList">
                <li class="account-menu-item menu-header active"><a href="javascript:void(0);" class="positionRelative"><i class="fa fa-solid fa-user"></i> My Account <span><i class="fa fa-minus menu-toggle-icon" aria-hidden="true"></i></span></a>
                    <div class="menu-content" id="accountMenuContent">
                        <ul>
                            <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('user.dashboard') }}"
                                   class="{{ request()->routeIs('user.dashboard') ? 'activeclass' : '' }}">
                                    My Account
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('user.account.profile') ? 'active' : '' }}">
                                <a href="{{ route('user.account.profile') }}" 
                                class="{{ request()->routeIs('user.account.profile') ? 'activeclass' : '' }}">
                                    Edit your Contact and Billing Information
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('user.account.password') ? 'active' : '' }}">
                                <a href="{{ route('user.account.password') }}"
                                  class="{{ request()->routeIs('user.account.password') ? 'activeclass' : '' }}">
                                    Change your Password
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('user.account.upgrade') ? 'active' : '' }}">
                                <a href="{{ route('user.account.upgrade') }}"
                                  class="{{ request()->routeIs('user.account.upgrade') ? 'activeclass' : '' }}">
                                    Upgrade My Package
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('user.account.payment.history') ? 'active' : '' }}">
                                <a href="{{ route('user.account.payment.history') }}"
                                  class="{{ request()->routeIs('user.account.payment.history') ? 'activeclass' : '' }}">
                                    Check Payment History
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.contacts.import') ? 'active' : '' }}">
                    <a href="{{ route('user.contacts.import') }}" class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}"><i class="fa fa-database" aria-hidden="true"></i> Import Contacts</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.contacts.bad-report') ? 'active' : '' }}">
                    <a href="{{ route('user.contacts.bad-report') }}" class="{{ request()->routeIs('user.contacts.bad-report*') ? 'activeclass' : '' }}"><i class="fa fa-solid fa-user"></i> Bad Contacts Report</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.campaigns.create') ? 'active' : '' }}">
                    <a href="{{ route('user.campaigns.create') }}" class="{{ request()->routeIs('user.campaigns.*') ? 'activeclass' : '' }}"><i class="fa fa-envelope" aria-hidden="true"></i> Create An Email Campaign</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.email-stats.index') ? 'active' : '' }}">
                    <a href="{{ route('user.email-stats.index') }}" class="{{ request()->routeIs('user.email-stats.index') ? 'activeclass' : '' }}"><i class="fa fa-history" aria-hidden="true"></i> Campaign History</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.saved-templates.index') ? 'active' : '' }}">
                    <a href="{{ route('user.saved-templates.index') }}" class="{{ request()->routeIs('user.saved-templates.*') ? 'activeclass' : '' }}"><i class="fa fa-folder" aria-hidden="true"></i> Manage Custom Templates</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.autoresponders.index') ? 'active' : '' }}">
                    <a href="{{ route('user.autoresponders.index') }}" class="{{ request()->routeIs('user.autoresponders.index') ? 'activeclass' : '' }}"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> My Auto Responders</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.autoresponders.create') ? 'active' : '' }}">
                    <a href="{{ route('user.autoresponders.create') }}" class="{{ request()->routeIs('user.autoresponders.create') ? 'activeclass' : '' }}"><i class="fa fa-calendar" aria-hidden="true"></i> Add an Auto Responder</a>
                </li>
                <li class="account-menu-item {{ request()->routeIs('user.image-gallery.index') ? 'active' : '' }}">
                    <a href="{{ route('user.image-gallery.index') }}" class="{{ request()->routeIs('user.image-gallery.*') ? 'activeclass' : '' }}"><i class="fa fa-picture-o" aria-hidden="true"></i> My Image Gallery</a>
                </li>
                <li class="account-menu-item menu-header"><a href="javascript:void(0);" class="positionRelative"><i class="fa fa-address-book" aria-hidden="true"></i> Contacts List <span><i class="fa fa-plus menu-toggle-icon" aria-hidden="true"></i></span></a>
                    <div class="menu-content" id="contactsMenuContent" style="display: none;">
                        <ul>
                            <li>
                                <a href="{{ route('user.groups.index') }}" class="{{ request()->routeIs('user.groups.index') ? 'activeclass' : '' }}">Manage your Contact List</a>
                            </li>
                            <li>
                                <a href="{{ route('user.groups.create') }}" class="{{ request()->routeIs('user.groups.create') ? 'activeclass' : '' }}">Add/Create a Group</a>
                            </li>
                            <li>
                                <a href="{{ route('user.contacts.import') }}" class="{{ request()->routeIs('user.contacts.import') ? 'activeclass' : '' }}">Add Contacts</a>
                            </li>
                            <li>
                                <a href="{{ route('user.contacts.assign') }}" class="{{ request()->routeIs('user.contacts.assign') ? 'activeclass' : '' }}">Assign Contacts you've added to existing Contact Groups</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="account-menu-item">
                    <a href="{{ route('user.mailing-list.store') }}" class="{{ request()->routeIs('user.mailing-list') ? 'activeclass' : '' }}"><i class="fa fa-handshake-o" aria-hidden="true"></i> Join Mailing List code</a>
                </li>
                <li class="account-menu-item">
                    <a href="{{ route('user.referral') }}" class="{{ request()->routeIs('user.referral') ? 'activeclass' : '' }}"> <i class="fa fa-users" aria-hidden="true"></i> Refer a friend</a>
                </li>
            </ul>
        </div>




{{-- =========================================================
     MENU CSS
========================================================= --}}

<style>


    /*
    |--------------------------------------------------------------------------
    | Toggle Icon
    |--------------------------------------------------------------------------
    */
    .account-menu-item a i{
        padding-right: 5px;
    }

    .positionRelative {
        position: relative;
    }

    .menu-toggle-icon {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        line-height: 1;
        color: #111;
    }

    .account-menu-item {
        margin-bottom: 7px;
        border-bottom: 0px solid #fef5f5 !important;
    }
    .account-menu-item a {
        color: #5b5b5b !important;
        display: block;
        line-height: 23px;
        padding: 11px 12px 12px 12px !important;
        background-color: #efefef;
        font-size: 15px;
        border-bottom: 0px solid #fef5f5;
        border-radius: 6px;
        overflow: hidden;
    }

    .menu-content {
        padding: 8px;
        background-color: #ffffff;
    }
    .menu-content li {
        border-bottom: 0px solid #fef5f5 !important;
    }
    .account-menu-item .menu-content a {
        background-color: #ffffff;
        border-radius: 0px;
        border-bottom: 1px solid #e2e2e2;
        padding: 11px 8px !important;
        line-height: 21px;
        font-size: 14px;
        color: #5b5b5b !important;
    }
    .account-menu-item .menu-content li:last-child a {
        border-bottom: 0px solid #e2e2e2;
    }
    li.account-menu-item.active a, li.account-menu-item a:hover, li.account-menu-item:hover .menu-toggle-icon {
        background-color: #e62d29;
        color: #ffffff !important;
    }
    li.account-menu-item.active i {
        color: #ffffff;
    }
    li.account-menu-item.active .menu-content li a {
        color: #5b5b5b !important;
        background-color: #ffffff !important;
    }
    li.account-menu-item.active .menu-content li a:hover, li.account-menu-item.active .menu-content li a.activeclass, .menu-content li a:hover.activeclass, .menu-content li a:hover {
        color: #e62d29 !important;
        background-color: transparent !important;
    }
</style>


{{-- =========================================================
     MENU JAVASCRIPT
========================================================= --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

$(document).ready(function () {


    $('.menu-header').on('click', function () {

    var $this = $(this);
    var $content = $this.find('.menu-content');
    var $icon = $this.find('.menu-toggle-icon');

    $content.stop(true, true).slideToggle(200, function () {

        if ($(this).is(':visible')) {
            $icon
                .removeClass('fa-plus')
                .addClass('fa-minus');
        } else {
            $icon
                .removeClass('fa-minus')
                .addClass('fa-plus');
        }

    });

});


});

</script>