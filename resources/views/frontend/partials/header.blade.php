<header>
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-6">
        <div class="logo"> <a class="logo" href="{{ route('home') }}"><img src="{{ asset('assets/frontend/images/logo.jpg') }}" alt="Constant Email" class="imgResponsive"></a></div>
      </div>
      <div class="col-lg-7 col-md-6 text-right"> 
  
        @guest

            <a href="{{ route('login') }}" class="custom-btn1 transparent-btn">
                Customer Login
            </a>

            <a href="{{ route('register') }}" class="custom-btn1 orangeBg">
                Register
            </a>

        @endguest



        @auth
    

        <!-- <div class="dropdown d-inline-block">

            <button class="custom-btn1 transparent-btn dropdown-toggle"
                    data-bs-toggle="dropdown">

                {{ ucfirst(auth()->user()->username) }}

            </button>

            <div class="dropdown-menu dropdown-menu-right">

                <a class="dropdown-item"
                   href="{{ route('user.dashboard') }}">
                    Dashboard
                </a>

                <a class="dropdown-item"
                   href="#">
                    Profile
                </a>

                <form method="POST"
                      action="{{ route('user.logout') }}">
                    @csrf

                    <button class="dropdown-item">
                        Logout
                    </button>
                </form>

            </div>

        </div> -->

        <div class="dropdown d-inline-block">

    <button
        type="button"
        class="custom-btn1 orangeBg dropbtn dropdown-toggle d-flex align-items-center justify-content-center"
        id="userDropdown"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">

        <div class="userProfileImage">
            <a href="#" class="">
            {{ strtoupper(
                substr(auth()->user()->name ?: auth()->user()->username, 0, 1) .
                substr(auth()->user()->last_name ?? '', 0, 1)
            ) }}  
            <!-- {{ strtoupper(substr(auth()->user()->username, 0, 1)) }} -->
          </a>
        </div>

        <!-- {{ ucfirst(auth()->user()->username) }} -->
        {{ auth()->user()->name
            ? ucfirst(trim(auth()->user()->name) . ' ' . ucfirst(auth()->user()->last_name))
            : ucfirst(auth()->user()->username) . ' ' . ucfirst(auth()->user()->last_name)
        }}

    </button>

    <div id="myDropdown" class="headerSettingsLinks dropdown-content dropdown-menu dropdown-menu-right"
         aria-labelledby="userDropdown">

         <ul class="mb-0">

            <li>

        <a class="dropdown-item"
           href="{{ route('user.dashboard') }}">
            My Account
        </a>
    </li>
        <!-- <a class="dropdown-item"
           href="#">
            Profile
        </a> -->
        <li>
        <form method="POST" action="{{ route('user.logout') }}">
            @csrf

            <button type="submit" class="dropdown-item">
                Logout
            </button>
        </form>
        </li>
        </ul>
    </div>

</div>

    
@endauth

      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg redBg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> <span class="navbar-toggler-icon"></span> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav">
          <li class="nav-item"> 
            <a class="nav-link active" href="{{ route('home') }}">Home </a> 
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="{{ route('feature') }}">Features</a> 
          </li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('pricing') }}">Pricing</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('managed-accounts') }}">Managed Accounts</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('template') }}">Templates</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('email.verification') }}">Validate Email</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('contact') }}">Contact Us</a> </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>