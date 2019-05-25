<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version  v1.0.6
 * @link  http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license  MIT
 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="hoahong">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="hoahong">
  <link rel="shortcut icon" href="<?php echo e(asset('img/favicon.png')); ?>">
  <title>HoaHong</title>

  <!-- Icons -->

  <link href="<?php echo e(asset('public/css/font-awesome.min.css')); ?>" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="<?php echo e(asset('public/css/style.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('public/css/select2.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('public/css/bootstrap.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('public/css/daterangepicker.css')); ?>" rel="stylesheet">
  <!-- Styles required by this views -->
  <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
  <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="<?php echo e(asset('public/DataTables/dataTables.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('public/js/datepicker/bootstrap-datepicker.css')); ?>">
  <link href="<?php echo e(asset('public/css/awesome/css/all.css')); ?>" rel="stylesheet">
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
  <?php echo $__env->make('panel.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="app-body">
    <?php echo $__env->make('panel.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Main content -->
    <main class="main">

      <!-- Breadcrumb -->
      <?php echo $__env->make('panel.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      <?php echo $__env->yieldContent('content'); ?>
      <!-- /.container-fluid -->
    </main>

    <?php echo $__env->make('panel.asidemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  </div>

  <?php echo $__env->make('panel.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php echo $__env->make('panel.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->yieldContent('myscript'); ?>
  <!-- <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script> -->
  <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script> -->
  <script src="<?php echo e(asset('public/DataTables/datatables.min.js')); ?>"></script>
  <script src="<?php echo e(asset('public/js/sweetalert.min.js')); ?>"></script>
  <script src="<?php echo e(asset('public/js/select2.min.js')); ?>"></script>
  <script src="<?php echo e(asset('public/maskmoney/jquery.maskMoney.js')); ?>"></script>
  <script src="<?php echo e(asset('public/js/datepicker/bootstrap-datepicker.js')); ?>"></script>
  <script src="<?php echo e(asset('public/js/daterangepicker.js')); ?>"></script>



    <!-- <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
    <script src="https://datatables.yajrabox.com/js/handlebars.js"></script> -->

</body>
</html>
