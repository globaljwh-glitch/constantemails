<!-- Tab Mobile View Header -->
<header class="tabMobileView header navbar fixed-top d-lg-none">
    <div class="nav-toggle">
        <a href="javascript:void(0);" class="nav-link sidebarCollapse" data-placement="bottom">
            <i class="flaticon-menu-line-2"></i>
        </a>
        <a href="index.html" class=""> <img src="{{  asset('assets/admin/assets/img/logo-3.jpg') }}" class="img-fluid"
                alt="logo"></a>
    </div>
    <ul class="nav navbar-nav">
        <li class="nav-item d-lg-none">
            <form class="form-inline justify-content-end" role="search">
                <input type="text" class="form-control search-form-control mr-3">
            </form>
        </li>
    </ul>
</header>
<!-- Tab Mobile View Header -->

<!--  BEGIN NAVBAR  -->
<header class="header navbar fixed-top navbar-expand-sm">
    <a href="javascript:void(0);" class="sidebarCollapse d-none d-lg-block" data-placement="bottom"><i
            class="flaticon-menu-line-2"></i></a>



    <!-- <ul class="navbar-nav flex-row mr-lg-auto ml-lg-0  ml-auto">
        <li class="nav-item dropdown message-dropdown ml-lg-4">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="flaticon-mail-10"></span><span class="badge badge-primary">13</span>
            </a>
            <div class="dropdown-menu  position-absolute" aria-labelledby="messageDropdown">
                <a class="dropdown-item title" href="javascript:void(0);">
                    <i class="flaticon-chat-line mr-3"></i><span>You have 13 new messages</span>
                </a>
                <a class="dropdown-item" href="javascript:void(0);">
                    <div class="media">
                        <div class="usr-img online mr-3">
                            <img class="usr-img rounded-circle" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}"
                                alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <div class="mt-0">
                                <p class="text mb-0">Browse latest projects...</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="meta-user-name mb-0">Kara Young</p>
                                <p class="meta-time mb-0  align-self-center">1 min ago</p>
                            </div>
                        </div>
                    </div>

                    <div class="media">
                        <div class="usr-img mr-3">
                            <img class="usr-img rounded-circle" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}"
                                alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <div class="mt-0">
                                <p class="text mb-0">Design, Development and...</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="meta-user-name mb-0">Amy Diaz</p>
                                <p class="meta-time mb-0  align-self-center">5 mins ago</p>
                            </div>
                        </div>
                    </div>

                    <div class="media">
                        <div class="usr-img online mr-3">
                            <img class="usr-img rounded-circle" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}"
                                alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <div class="mt-0">
                                <p class="text mb-0">We can ensure...</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="meta-user-name mb-0">Shaun Park</p>
                                <p class="meta-time mb-0  align-self-center">1 day ago</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a class="footer dropdown-item" href="javascript:void(0);">
                    <div class="btn btn-info mb-3 mr-2 btn-rounded"><i class="flaticon-arrow-right mr-3"></i> View more
                    </div>
                </a>
            </div>
        </li>

        <li class="nav-item dropdown notification-dropdown ml-3">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="flaticon-bell-4"></span><span class="badge badge-success">15</span>
            </a>
            <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                <a class="dropdown-item title" href="javascript:void(0);">
                    <i class="flaticon-bell-13 mr-3"></i> <span>You have 15 new notifications</span>
                </a>

                <a class="dropdown-item text-center  p-1" href="javascript:void(0);">

                    <div class="notification-list ">

                        <div class="notification-item position-relative  mb-3">
                            <div class="c-dropdown text-right">
                                <span id="c-dropdonbtn" class="c-dropbtn mr-2"><i class="flaticon-dots"></i></span>
                                <div class="c-dropdown-content">
                                    <div class="c-dropdown-item">View</div>
                                    <div class="c-dropdown-item">Delete</div>
                                </div>
                            </div>

                            <h6 class="mb-1">5 new members joined today</h6>
                            <p><span class="meta-time">1 minute ago</span> . <span class="meta-member-notification">4
                                    members</span></p>
                            <ul class="list-inline badge-collapsed-img mt-3">
                                <li class="list-inline-item chat-online-usr">
                                    <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" alt="admin-profile"
                                        class="ml-0">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" alt="admin-profile">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" alt="admin-profile">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" alt="admin-profile">
                                </li>
                            </ul>

                        </div>

                        <div class="notification-item position-relative  mb-3">

                            <div class="c-dropdown text-right">
                                <span id="c-dropdonbtn2" class="c-dropbtn mr-2"><i class="flaticon-dots"></i></span>
                                <div class="c-dropdown-content">
                                    <div class="c-dropdown-item">View</div>
                                    <div class="c-dropdown-item">Delete</div>
                                </div>
                            </div>

                            <h6 class="mb-1">Very long description...</h6>
                            <p><span class="meta-time">5 minutes ago</span> . <span class="meta-member-notification">5
                                    members</span></p>
                            <ul class="list-inline badge-collapsed-img mt-3">
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}"
                                        class="ml-0">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                            </ul>

                        </div>

                        <div class="notification-item position-relative  mb-3">
                            <div class="c-dropdown text-right">
                                <span class="c-dropbtn mr-2"><i class="flaticon-dots"></i></span>
                                <div class="c-dropdown-content">
                                    <div class="c-dropdown-item">View</div>
                                    <div class="c-dropdown-item">Delete</div>
                                </div>
                            </div>

                            <h6 class="mb-1">New item are in queue</h6>
                            <p><span class="meta-time">25 minutes ago</span> . <span class="meta-member-notification">3
                                    members</span></p>
                            <ul class="list-inline badge-collapsed-img mt-3">
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}"
                                        class="ml-0">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                                <li class="list-inline-item chat-online-usr">
                                    <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/90x90.jpg') }}">
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
                <a class="footer dropdown-item text-center p-2">
                    <span class="mr-1">View All</span>
                    <div class="btn btn-gradient-warning rounded-circle"><i
                            class="flaticon-arrow-right flaticon-circle-p"></i></div>
                </a>
            </div>
        </li>
    </ul> -->


    <ul class="navbar-nav flex-row ml-lg-auto">





        <li class="nav-item dropdown user-profile-dropdown ml-lg-0 mr-lg-2 ml-3 order-lg-0 order-1">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="flaticon-user-12"></span>
            </a>
            <div class="dropdown-menu  position-absolute" aria-labelledby="userProfileDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="mr-1 flaticon-user-6"></i> <span>My Profile</span>
                </a>
                <!-- <a class="dropdown-item" href="apps_scheduler.html">
                    <i class="mr-1 flaticon-calendar-bold"></i> <span>My Schedule</span>
                </a>
                <a class="dropdown-item" href="apps_mailbox.html">
                    <i class="mr-1 flaticon-email-fill-1"></i> <span>My Inbox</span>
                </a> -->

                <div class="dropdown-divider"></div>

                <!-- The new Logout Link using Javascript to submit the hidden form -->
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mr-1 flaticon-power-button"></i> <span>Log Out</span>
                </a>

                <!-- The Hidden POST Form -->
                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" class="d-none"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

        <!-- <li class="nav-item dropdown cs-toggle order-lg-0 order-3">
            <a href="#" class="nav-link toggle-control-sidebar suffle">
                <span class="flaticon-menu-dot-fill d-lg-inline-block d-none"></span>
                <span class="flaticon-dots d-lg-none"></span>
            </a>
        </li> -->
    </ul>
</header>
<!--  END NAVBAR  -->