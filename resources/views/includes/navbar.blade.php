<?php
use Illuminate\Support\Str;
?>
<nav
  class="navbar navbar-expand-lg navbar-light navbar-damkar fixed-top navbar-fixed-top"
  data-aos="fade-down"
>
  <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand">
      <img src="/images/logo-damkar.png" alt="Logo" />
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarResponsive"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ (request()->is('/*')) ? 'active' : '' }} ">Home</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('categories') }}" class="nav-link {{ (request()->is('categories*')) ? 'active' : '' }}">Kategori</a>
        </li>
        @guest
          {{-- <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
          </li> --}}
          <li class="nav-item">
            <a
              href="{{ route('login') }}"
              class="btn btn-success nav-link px-4 text-white"
              >Sign In</a>
          </li>
        @endguest
      </ul>
      @auth
        <!-- Desktop Menu -->
        <ul class="navbar-nav d-none d-lg-flex">
          <li class="nav-item dropdown">
            <a
              href="#"
              class="nav-link"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
            >
              <img
                src="/images/logo-damkar.png"
                alt=""
                class="rounded-circle-2 mr-2 profile-picture"
              />
              Hi, {{ str::limit(Auth::user()->bidang, 10) }}
            </a>
            <div class="dropdown-menu">
              <a href="{{ route('home') }}" class="dropdown-item">Home</a>
              @if ((Auth::user()->roles) === "KASIR")
                <a href="{{ route('dashboard-kasir') }}" class="dropdown-item">Dashboard - Kasir</a>
              @elseif((Auth::user()->roles) === "ADMIN")
                <a href="{{ route('dashboard-admin') }}" class="dropdown-item">Dashboard - ADMIN</a>
              @else 
                <a href="{{ route('dashboard-user') }}" class="dropdown-item">Dashboard</a>
              @endif
              
              {{-- <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item"
                >Settings</a
              > --}}
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();" class="dropdown-item">Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </li>
          <li class="nav-item">
            {{-- <a href="{{ route('cart') }}" class="nav-link d-inlink-block mt-2">
              @php
                  $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
              @endphp
              @if ($carts > 0)
                <img src="/images/icon-cart-filled.svg" alt="" />
                <div class="card-badge">{{ $carts }}</div>
                @else
                <img src="/images/icon-cart-empty.svg" alt="" />
              @endif
              
            </a> --}}
          </li>
        </ul>

        <!-- Mobile Menu -->
        <ul class="navbar-nav d-block d-lg d-lg-none">
          <li class="nav-item">
          <li class="nav-item">
            {{-- <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a> --}}
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              Hi {{ Auth::user()->bidang }}
            </a>
          </li>          
          <li class="nav-item">
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"  class="btn btn-danger nav-link px-4 text-white">Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      @endauth
    </div>
  </div>
</nav>