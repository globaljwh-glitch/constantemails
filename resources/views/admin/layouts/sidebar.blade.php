<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <div id="dismiss" class="d-lg-none"><i class="flaticon-cancel-12"></i></div>

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand d-none d-lg-block w-100 p-0 m-0">
            <!-- px-4 creates a perfect, even gap on the left and right -->
            <li class="nav-item w-100 text-center px-4 py-3">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-block m-0 p-0 w-100">
                    <img src="{{ asset('assets/admin/assets/img/logo-3.jpg') }}" alt="logo" class="img-fluid mx-auto"
                        style="width: 100% !important; height: auto !important; max-height: 90px !important; object-fit: contain;">
                </a>
            </li>
        </ul>


        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <!-- Kept original classes, removed data-toggle="collapse", added onclick -->
                <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle" aria-expanded="false"
                    onclick="window.location.href=this.href; return false;">
                    <div class="">
                        <i class="flaticon-computer-6 ml-3"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#ui-features" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-elements"></i>
                        <span>Manage Templates</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="ui-features" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('template-categories.index') }}">Template Categories </a>
                    </li>
                    <li>
                        <a href="{{ route('templates.create') }}">Add Templates </a>
                    </li>
                    <li>
                        <a href="{{ route('templates.index') }}">All Templates </a>
                    </li>


                </ul>
            </li>

            <li class="menu">
                <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-3d-cube"></i>
                        <span>Manage Resources</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="components" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('resource-categories.index') }}"> Resource Category </a>
                    </li>
                    <li>
                        <a href="{{ route('resource-articles.create') }}"> Add Article </a>
                    </li>
                    <li>
                        <a href="{{ route('resource-articles.index') }}"> All Articles </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-copy-line"></i>
                        <span>Manage CMS</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="forms" data-parent="#accordionExample">

                    <li>
                        <a href="{{ route('cms-articles.index') }}"> All Articles </a>
                    </li>



                    <li>
                        <a href="{{ route('cms-articles.create') }}"> Add Article </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-layers"></i>
                        <span>Contact Categories</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="elements" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('contact-categories.index') }}"> Add Category </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a href="#editors" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-edit-2"></i>
                        <span>Manage Users</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="editors" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('users.index') }}"> All Users </a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}"> Add User </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-table"></i>
                        <span>Manage Packages</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="tables" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('packages.store') }}"> Create Package </a>
                    </li>
                    <li>
                        <a href="{{ route('packages.index') }}"> All Packages </a>
                    </li>



                </ul>
            </li>

            <!-- <li class="menu">
                <a href="#charts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-bar-chart-2"></i>
                        <span>User Templates</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="charts" data-parent="#accordionExample">
                    
                    
                    <li>
                        <a href="charts_cssplot.html"> CSS Plot </a>
                    </li>

                    
                    
                    <li>
                        <a href="charts_google.html"> Google </a>
                    </li>
                </ul>
            </li> -->

            <li class="menu">
                <a href="#maps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-map-1"></i>
                        <span>Email Templates</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="maps" data-parent="#accordionExample">


                    <li>
                        <a href="{{ route('email-templates.create') }}"> Create Template </a>
                    </li>
                    <li>
                        <a href="{{ route('email-templates.index') }}"> All Templates </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a href="#mailing" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-mail-19"></i>
                        <span>Settings</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="mailing" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('settings.index') }}"> All Settings </a>
                    </li>
                    <!-- <li>
                        <a href="{{ route('settings.index') }}"> View Settings </a>
                    </li> -->


                </ul>
            </li>

            <!-- <li class="menu">
                <a href="#modules" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="flaticon-computer-5"></i>
                        <span>Refferals</span>
                    </div>
                    <div>
                        <i class="flaticon-right-arrow"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="modules" data-parent="#accordionExample">
                    <li>
                        <a href="modules_widgets.html"> Widgets </a>
                    </li>

                </ul>
            </li> -->





        </ul>
    </nav>

</div>
<!--  END SIDEBAR  -->