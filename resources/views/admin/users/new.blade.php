@extends('admin.layouts.master')

@section('title', __('users.listNewusers'))
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
          <li class="breadcrumb-item active">{{ __('users.listNewusers') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="card">
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card-header pb-4">
    <h3 class="card-title">{{ __('users.listNewusers') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('users.name') }}</th>
          <th>{{ __('users.email') }}</th>
          <th>{{ __('users.address') }}</th>
          <th>{{ __('users.phone') }}</th>
          <th>{{ __('users.role') }}</th>
          <th width="10%">{{ __('app.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($users) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($users as $key => $user)
            <tr id="column-{{ $user->id }}">
              <td>{{ app('request')->input('page') ? \App\Role::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->address }}</td>
              <td>{{ $user->phone }}</td>
              <td>{{ $user->role->name }}</td>
              <td>
                <div class="form-group">
                  <div class="row">
                    <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('{{ __('user.delete') }}','{{ __('app.confirm') }}', {{ $user->id }})"></a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $users->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<script type="text/javascript" src="{{ asset('custom/admin-user.js') }}"></script>
@endsection
