<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('images/sekarsa.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SEKARSA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Storage::url( Auth::user()->photo ?? 'tidak ada foto') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->bidang }} - {{ Auth::user()->name }}</a>
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
          <a href="{{ route('dashboard-kasir') }}" class="nav-link {{ (request()->is('kasir')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kasKecil.index') }}" class="nav-link {{ (request()->is('kasir/kasKecil')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Kas Kecil
            </p>
          </a>
        </li>

        <li class="nav-item {{ (request()->is('kasir/data-transaction*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('kasir/data-transaction*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              Transactions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('transaction.index') }}" class="nav-link {{ (request()->is('kasir/data-transaction/transaction*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transaksi Penjualan</p>
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