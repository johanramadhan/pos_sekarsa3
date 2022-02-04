@extends('layouts.app')

@section('title')
    Sispras Homepage
@endsection

@section('content')
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        @guest
          <form method="POST" action="{{ route('login') }}" class="sign-in-form">
            @csrf
            <h2 class="title">Sign In</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input id="email" type="email" class="form-control w-75 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input id="password" type="password" class="form-control w-75 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <input type="submit" value="Login" class="btn solid" />            
            {{-- <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                  <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-linkedin-in"></i>
              </a>
            </div> --}}
          </form>
        @endguest

        @auth
          <form class="sign-in-form">
            <h2 class="title">Hai, {{ Auth::user()->name }}</h2>
            <h2 class="title">You Are Login Now!</h2>
            @if ((Auth::user()->roles) === "KASIR")
              <a href="{{ route('dashboard-kasir') }}" class="btn solid">
                Dashboard
              </a>
            @elseif((Auth::user()->roles) === "ADMIN")
              <a href="{{ route('dashboard-admin') }}" class="btn solid">
                Dashboard
              </a>
            @endif
          </form>
        @endauth
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>SEKARSA</h3>
          <p>
            Berkehendaklah hari ini, semoga orderan banyak
          </p>
        </div>
        <img src="{{ url('/images/1.svg') }}" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
            laboriosam ad deleniti.
          </p>
          <button href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
            class="btn transparent">
            <p>
              Logout
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </button>
          <button class="btn transparent" id="sign-in-btn">
            Back >
          </button>
        </div>
        <img src="{{ url('/images/2.svg') }}" class="image" alt="" />
      </div>
    </div>
  </div>
 
@endsection