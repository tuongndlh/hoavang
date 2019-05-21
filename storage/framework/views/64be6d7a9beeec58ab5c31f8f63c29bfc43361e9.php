<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/Bizapp"><i class="fa fas fa-home"></i> Trang chủ </a>
      </li>

      <!-- Sản phẩm -->

      <li class="navigation-header"><span>Sản phẩm</span> </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fas fa-list"></i>Danh sách sản phẩm</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="far fa-list-alt"></i>Nhóm mặt hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="far fa-plus-square"></i>Tạo mới sản phẩm</a>
      </li>

      </li>

      <!-- Khuyến mãi -->

      <li class="navigation-header"><span>Khuyến mãi</span> </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fas fa-gift"></i>Các khuyến mãi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('promotion')); ?>"><i class="fas fa-tags"></i>Tạo mới khuyến mãi</a>
      </li>

      </li>



      <!-- Truyền thông -->

      <li class="navigation-header"><span>Truyền thông</span> </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa far fa-comment"></i>Tin nhắn</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('message')); ?>"><i class="fa fal fa-list-alt"></i>Mẫu tin nhắn</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('message_setting')); ?>"><i class="fa fas fa-cogs"></i>Cài đặt tin nhắn</a>
          </li>

        </ul>
      </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa far fa-bullhorn"></i>Thông báo</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('message_setting')); ?>"><i class="fa fal fa-list-alt"></i>Mẫu thông báo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('campaign_news')); ?>"><i class="fa fas fa-cogs"></i>Cài đặt thông báo</a>
          </li>

        </ul>
      </li>
      <!-- Khách hàng -->

      <li class="navigation-header"><span>Khách hàng</span> </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('kpi')); ?>"><i class="fa fas fa-tasks"></i>Chỉ tiêu khách hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('customer')); ?>"><i class="fa far fa-users"></i>Danh sách khách hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fa  far fa-address-book"></i>Tập khách hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fa far fa-street-view"></i>Người liên hệ</a>
      </li>
      <!-- Quản trị -->
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fas fa-th-large"></i>Khai báo</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('group_customer')); ?>"><i class="fa fas fa-th-list"></i>Phân loại khách hàng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('area')); ?>"><i class="fa fas fa-map-marker"></i>Khu vực</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('channel')); ?>"><i class="fa fal fa-tasks"></i>Kênh</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('cust_catalogue')); ?>"><i class="fa fal fa-map"></i>Nhóm</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('tax')); ?>"><i class="fa fas fa-percent"></i>Thuế</a>
          </li>

        </ul>
      </li>


      <li class="navigation-header"><span>Quản trị</span> </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fa far fa-building"></i>Công ty</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('department')); ?>"><i class="fa far fa-object-ungroup"></i>Bộ phận</a>
      </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa far fa-user-circle"></i>Tài khoản</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('user')); ?>"><i class="fa fa-user"></i></i>Tài khoản nhân viên</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fa far fa-universal-access"></i>Tài khoản khách hàng</a>
          </li>

        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?php echo e(route('item_code')); ?>"><i class="fa fas fa-credit-card"></i></i>Thanh toán</a>
      </li>

    </ul>

  </nav>
  <!-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> -->
</div>
