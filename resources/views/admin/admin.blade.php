<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
  {{--   <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link href="{{ asset('fonts/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <style>
        [v-cloak] {
          display: none;
        }
      </style>      
  </head>
  <!-- Fixed Top -->
  {{-- <body class="hold-transition skin-blue sidebar-mini fixed"> --}}
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">  
      <div class="wrapper" id="app" v-cloak>
        <!-- Main Header -->
        @include('admin.header')
        
        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.sidebar')      

        <!-- Content Wrapper. Contains page content --> 
        @include('admin.content-page')

        <!-- Control Sidebar -->
        @include('admin.control_sidebar')

        <!-- Main Footer -->
        @include('admin.footer')

      </div>
      <!-- ./wrapper -->
      
      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}"></script>     
      <script src="{{ asset('js/admin/adminlte.min.js') }}"></script>
     
      {{-- @yield('scripts')     --}}
  </body>
</html>