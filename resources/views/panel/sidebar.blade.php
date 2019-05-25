<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/hoavang"><i class="fa fas fa-home"></i> Trang chủ </a>
      </li>


    <!-- Khai báo -->
    <li class="navigation-header"><span>Khai báo</span> </li>
    <li class="nav-item">
      <a class="nav-link"  href="{{ route('reportall') }}"><i class="fas fa-keyboard"></i>Nhập báo cáo</a>
      <a class="nav-link"  href="{{ route('report') }}"><i class="far fa-eye"></i>Xem báo cáo</a>
        @if(Auth::user()->id == 1 )
      <a class="nav-link"  href="{{ route('admin_report') }}"><i class="fas fa-laptop-medical"></i>Xem báo cáo tất cả</a>
      @endif
      </li>

        <div>
          &nbsp;
        </div>
      </li>
    </ul>
  </nav>
  <!-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> -->
</div>
