<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/hoavang"><i class="fa fas fa-home"></i> Trang chủ </a>
      </li>


    <!-- Khai báo -->
    <li class="navigation-header"><span>Khai báo</span> </li>
    <li class="nav-item">
      <a class="nav-link"  href="<?php echo e(route('reportall')); ?>"><i class="fas fa-keyboard"></i>Nhập báo cáo</a>
      <a class="nav-link"  href="<?php echo e(route('report')); ?>"><i class="far fa-eye"></i>Xem báo cáo</a>
        <?php if(Auth::user()->id == 1 ): ?>
      <a class="nav-link"  href="<?php echo e(route('admin_report')); ?>"><i class="fas fa-laptop-medical"></i>Xem báo cáo tất cả</a>
      <?php endif; ?>
      </li>

        <div>
          &nbsp;
        </div>
      </li>
    </ul>
  </nav>
  <!-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> -->
</div>
