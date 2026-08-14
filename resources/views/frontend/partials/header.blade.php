<header>
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-6">
        <div class="logo"> <a class="logo" href="index.html"><img src="{{ asset('assets/frontend/images/logo.jpg') }}" alt="Constant Email" class="imgResponsive"></a></div>
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
    @if(!auth()->user()->is_admin)

        <div class="dropdown d-inline-block">

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

        </div>

    @endif
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
            <a class="nav-link active" href="index.html">Home </a> 
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="feature_page.html">Features</a> 
          </li>
          <li class="nav-item"> <a class="nav-link" href="pricing.html">Pricing</a> </li>
          <li class="nav-item"> <a class="nav-link" href="managed_accounts_new.html">Managed Accounts</a></li>
          <li class="nav-item"> <a class="nav-link" href="our_template.html">Templates</a> </li>
          <li class="nav-item"> <a class="nav-link" href="resources.html">Resources</a> </li>
          <li class="nav-item"> <a class="nav-link" href="contact.html">Contact Us</a> </li>
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