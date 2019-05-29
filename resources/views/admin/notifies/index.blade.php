@extends('admin.layouts.master')

@section('title', __('notifies.lists'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<section class="content-header ml-2">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('notifies.lists') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('notifies.lists') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('notifies.notify') }}</th>
          <th width="10%">{{ __('notifies.seen') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($notifies) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($notifies as $key => $notify)
            <tr id="column-{{ $notify->id }}">
              <td>{{ app('request')->input('page') ? \App\Catalog::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td id="name-{{ $notify->id }}"><a onclick="seen({{ $notify->id }})" href="{{ $notify->link }}">{{ $notify->notify }}</a></td>
              <td>
                @if($notify->status == 1)
                  <span class="float-right text-muted text-sm"><i class="mr-2"><i class="fa fa-check" aria-hidden="true"></i></i></span>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $notifies->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
<script type="text/javascript" src="{{ asset('custom/admin-catalog.js') }}"></script>
<script type="text/javascript">
  function seen(id) {
    $.ajax({
      url: window.location.origin + '/admin/manager/notifies/seen/' + id,
      method: 'POST'
    })
  }
</script>
<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
