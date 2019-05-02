<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Masha Life</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview {{ (request()->segment(2) == '') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->segment(2) == '') ? 'active' : '' }}">
            <i class="nav-icon fa fa-dashboard"></i>
            <p>
              Starter Pages
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Active Page</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Inactive Page</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview {{ (request()->segment(2) == 'setting') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->segment(2) == 'setting') ? 'active' : '' }}">
            <i class="nav-icon fa fa-pie-chart"></i>
            <p>
              {{ __('app.setting') }}
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('roles.index') }}" class="nav-link {{ (request()->segment(3) === 'roles') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>{{ __('app.roles') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link {{ (request()->segment(3) === 'users') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>{{ __('app.users') }}</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

