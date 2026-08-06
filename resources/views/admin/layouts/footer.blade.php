<!--  BEGIN FOOTER  -->
    <footer class="footer-section theme-footer">

        <div class="footer-section-1  sidebar-theme">
            
        </div>

        <div class="footer-section-2 container-fluid">
            <div class="row">
                <div id="toggle-grid" class="col-xl-7 col-md-6 col-sm-6 col-12 text-sm-left text-center">
                    <ul class="list-inline links ml-sm-5">
                        <li class="list-inline-item">
                            <a target="_blank" href="https://themeforest.net/item/equation-responsive-admin-dashboard-template/23191987">Buy</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-5 col-md-6 col-sm-6 col-12">
                    <ul class="list-inline mb-0 d-flex justify-content-sm-end justify-content-center mr-sm-3 ml-sm-0 mx-3">
                        <li class="list-inline-item  mr-3">
                            <p class="bottom-footer">&#xA9; 2019 <a target="_blank" href="https://designreset.com/equation">Equation Admin Theme</a></p>
                        </li>
                        <li class="list-inline-item align-self-center">
                            <div class="scrollTop"><i class="flaticon-up-arrow-fill-1"></i></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--  END FOOTER  -->

    <!--  BEGIN PROFILE SIDEBAR  -->
    <aside class="profile-sidebar text-center">
        <div class="profile-content profile-content-scroll">
            <div class="usr-profile">
                <img src="{{ asset('assets/admin/assets/img/90x90.jpg') }}" alt="admin-profile" class="img-fluid">
            </div>
            <p class="user-name mt-4 mb-4">Vincent Carpenter</p>
            <div class="">
                <div class="accordion" id="user-stats">
                    <div class="card">
                        <div class="card-header pb-4 mb-4" id="status">
                            <h6 class="mb-0" data-toggle="collapse" data-target="#user-status" aria-expanded="true" aria-controls="user-status"><i class="flaticon-view-3 mr-2"></i> Status <i class="flaticon-down-arrow ml-2"></i> </h6>
                        </div>
                        <div id="user-status" class="collapse show" aria-labelledby="status" data-parent="#user-stats">
                            <div class="card-body text-left">
                                <ul class="list-unstyled pb-4">
                                    <li class="status-online"><a href="javascript:void(0);">Online</a></li>
                                    <li class="status-away"><a href="javascript:void(0);">Away</a></li>
                                    <li class="status-no-disturb"><a href="javascript:void(0);">Not Disturb</a></li>
                                    <li class="status-invisible"><a href="javascript:void(0);">Invisible</a></li>
                                    <li class="status-offline"><a href="javascript:void(0);">Offline</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-links text-left">
                <ul class="list-unstyled">
                    <li><a href="apps_mailbox.html"><i class="flaticon-mail-22"></i> Inbox</a></li>
                    <li><a href="user_profile.html"><i class="flaticon-user-11"></i> My Profile</a></li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="flaticon-power-off"></i> Logout
                        </a>
                        <form id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            style="display:none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <!--  BEGIN PROFILE SIDEBAR  -->
    
 