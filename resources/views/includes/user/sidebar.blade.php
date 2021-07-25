<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SISPRAS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('images/logo-damkar.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->bidang }}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    {{-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('dashboard-user') }}" class="nav-link {{ (request()->is('user')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('user/data-aset*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('user/data-aset*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-balance-scale"></i>
            <p>
              Data Aset
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('aset.index') }}" class="nav-link {{ (request()->is('user/data-aset/aset*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Aset</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ (request()->is('user/data-proposal*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('user/data-proposal*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>
              Data Pengajuan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('pengajuans.index') }}" class="nav-link {{ (request()->is('user/data-proposal/pengajuans*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengajuan</p>
              </a>
            </li>
          </ul>
        </li>
        
      </ul>

      <ul class="nav nav-pills nav-sidebar flex-column mt-5" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
            class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Logout
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>