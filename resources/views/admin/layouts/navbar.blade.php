<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('admin.home') }}" class="nav-link">{{ __('app.home') }}</a>
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> --}}
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-bell-o"></i>
        <span class="badge badge-warning navbar-badge" id="count-notifies">{{ $countNotifiesAdmin }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><span id="count-notifies2">{{ $countNotifiesAdmin }}</span> {{ __('notifies.notifies') }}</span>
        <div id="list-notifies"></div>
          @foreach($notifiesAdmin as $notify)
            <div class="dropdown-divider"></div>
            <a href="{{ $notify->link }}" class="dropdown-item" onclick="seen({{ $notify->id }})">
              <i class="mr-2"></i> <span id="message">{{ $notify->notify }}</span>
              @if($notify->status == 1)
                <span class="float-right text-muted text-sm"><i class="mr-2"><i class="fa fa-check" aria-hidden="true"></i></i></span>
              @endif
            </a>
          @endforeach
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.notifies.index') }}" class="dropdown-item dropdown-footer">{{ __('notifies.seeAll') }}</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
          class="fa fa-th-large"></i></a>
    </li>
  </ul>
</nav>

<script type="text/javascript">
  function seen(id) {
    $.ajax({
      url: window.location.origin + '/admin/manager/notifies/seen/' + id,
      method: 'POST'
    })
  }
</script>
