<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  @stack('prepend-style')

  @include('includes.admin.style')

  @stack('addon-style')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('includes.admin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('includes.admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('includes.admin.aside')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('includes.admin.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
@stack('prepend-script')
@include('includes.admin.script')
@stack('addon-script')
</body>
</html>
