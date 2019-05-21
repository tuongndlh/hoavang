<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.6
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="hoavang">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="hoavang">
  <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
  <title>hoavang</title>

  <!-- Icons -->

  <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/daterangepicker.css') }}" rel="stylesheet">
  <!-- Styles required by this views -->
  <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
  <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="{{ asset('public/DataTables/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/js/datepicker/bootstrap-datepicker.css') }}">
  <link href="{{ asset('public/css/awesome/css/all.css') }}" rel="stylesheet">
  <!-- <link  rel="stylesheet"   href="//cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css" /> -->
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"> -->

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> -->

</head>
<!-- BODY options, add following classes to body to change options
'.header-fixed' - Fixed Header
'.brand-minimized' - Minimized brand (Only symbol)
'.sidebar-fixed' - Fixed Sidebar
'.sidebar-hidden' - Hidden Sidebar
'.sidebar-off-canvas' - Off Canvas Sidebar
'.sidebar-minimized'- Minimized Sidebar (Only icons)
'.sidebar-compact'    - Compact Sidebar
'.aside-menu-fixed' - Fixed Aside Menu
'.aside-menu-hidden'- Hidden Aside Menu
'.aside-menu-off-canvas' - Off Canvas Aside Menu
'.breadcrumb-fixed'- Fixed Breadcrumb
'.footer-fixed'- Fixed footer
-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
  @include('panel.navbar')

  <div class="app-body">
    @include('panel.sidebar')
    <!-- Main content -->
    <main class="main">

      <!-- Breadcrumb -->
      @include('panel.breadcrumb')

      @yield('content')
      <!-- /.container-fluid -->
    </main>

    @include('panel.asidemenu')

  </div>

  @include('panel.footer')

  @include('panel.scripts')
  @yield('myscript')
  <!-- <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script> -->
  <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script> -->
  <script src="{{ asset('public/DataTables/datatables.min.js') }}"></script>
  <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
  <script src="{{ asset('public/js/select2.min.js') }}"></script>
  <script src="{{ asset('public/maskmoney/jquery.maskMoney.js') }}"></script>
  <script src="{{ asset('public/js/datepicker/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('public/js/daterangepicker.js') }}"></script>



    <!-- <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
    <script src="https://datatables.yajrabox.com/js/handlebars.js"></script> -->

</body>
</html>
