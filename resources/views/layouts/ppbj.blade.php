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

  @include('includes.ppbj.style')

  @stack('addon-style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('includes.ppbj.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('includes.ppbj.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('includes.ppbj.aside')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('includes.ppbj.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
@stack('prepend-script')
@include('includes.ppbj.script')
@stack('addon-script')
</body>
</html>
