<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <meta name="author" content="" />

    <title>@yield('title')</title>

    {{-- Style --}}
    @include('includes.style2')
      
  </head>

  <body>
    {{-- Navbar --}}
    {{-- @include('includes.navbar') --}}

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    {{-- @include('includes.footer') --}}

    {{-- Script --}}
    @include('includes.script2')
   
  </body>
</html>
