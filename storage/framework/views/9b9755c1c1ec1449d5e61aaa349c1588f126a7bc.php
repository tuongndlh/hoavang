<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/hoahong"><i class="fa fas fa-home"></i> Trang chủ </a>
      </li>


    <!-- Khai báo -->
    <li class="navigation-header"><span>Khai báo</span> </li>
    <li class="nav-item">
      <a class="nav-link"  href="<?php echo e(route('cost')); ?>"><i class="fas fa-file-invoice-dollar"></i>Loại học phí</a>
      <a class="nav-link"  href="<?php echo e(route('class')); ?>"><i class="far fa-id-card"></i>Danh sách lớp</a>
      <a class="nav-link"  href="<?php echo e(route('child')); ?>"><i class="fa far fa-user"></i>Danh sách cháu</a>
    </li>
    <!-- Quản lý -->
      <li class="navigation-header"><span>Quản lý</span> </li>
      <li class="nav-item">
       <a class="nav-link"  href="<?php echo e(route('dayoff')); ?>"><i class="fa far fa-object-ungroup"></i>Nhập ngày nghỉ</a>
      </li>
   <!-- Báo cáo -->
      <li class="navigation-header"><span>Báo cáo</span> </li>
      <li class="nav-item">
       <a class="nav-link"  href="<?php echo e(route('print')); ?>"><i class="fas fa-print"></i>In phiếu</a>
     </li>
       <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('sumary')); ?>"><i class="fas fa-hand-holding-usd"></i>Thu tiền</a>
      </li>
      <!-- <li class="nav-item">
       <a class="nav-link"  href="<?php echo e(route('statistic')); ?>"><i class="fas fa-sort-amount-up"></i>Thống kê</a>
     </li> -->
        <div>
          &nbsp;
        </div>
      </li>
    </ul>
  </nav>
  <!-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> -->
</div>
