<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('dist/img/sekarsa.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SEKARSA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{Storage::url(Auth::user()->photo)}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
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
          <a href="{{ route('dashboard-admin') }}" class="nav-link {{ (request()->is('admin')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('category.index') }}" class="nav-link {{ (request()->is('admin/category*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Kategori
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('supplier.index') }}" class="nav-link {{ (request()->is('admin/supplier*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Suppliers
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('customer.index') }}" class="nav-link {{ (request()->is('admin/customer*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Customers
            </p>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/data-product*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('admin/data-product*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>
              Data Produk
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('persediaan.index') }}" class="nav-link {{ (request()->is('admin/data-product/persediaan*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Persediaan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produk.index') }}" class="nav-link {{ (request()->is('admin/data-product/produk*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ (request()->is('admin/data-transaction*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('admin/data-transaction*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              Transactions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ (request()->is('admin/data-transaction/pengeluaran*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengeluaran</p>
              </a>
              <a href="{{ route('pembelian.index') }}" class="nav-link {{ (request()->is('admin/data-transaction/persediaan*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Persediaan</p>
              </a>
              <a href="{{ route('pembelian.index') }}" class="nav-link {{ (request()->is('admin/data-transaction/pembelian*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pembelian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('transaction.index') }}" class="nav-link {{ (request()->is('admin/data-transaction/transaction*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transaksi Penjualan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item {{ (request()->is('admin/data-proposal*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('admin/data-proposal*')) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('laporan.index') }}" class="nav-link {{ (request()->is('admin/laporan*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Penjualan</p>
              </a>
            </li>
            <li class="nav-item d-none">
              <a href="{{ route('proposal-galleries.index') }}" class="nav-link {{ (request()->is('admin/data-proposal/proposal-galleries*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Gallery</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">SETTINGS</li>
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users/Employees
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('setting.index') }}" class="nav-link {{ (request()->is('admin/setting*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Settings
            </p>
          </a>
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