@extends('admin.layouts.master')

@section('title', __('roles.lists'))
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
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('roles.lists') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="btn btn-success mb-3" id="new-record">Thêm mới</div>
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('roles.lists') }}</h3>
    <div class="card-tools">
      {{ Form::open(['method' => 'GET' ]) }}
        <div class="input-group input-group-sm" style="width: 150px;">
          <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $key ?? '' }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </div>
      {{ Form::close() }}
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('roles.name') }}</th>
          <th>{{ __('roles.users') }}</th>
          <th width="10%">{{ __('app.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($roles) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($roles as $key => $role)
            <tr id="column-{{ $role->id }}">
              <td>{{ app('request')->input('page') ? \App\Role::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td id="role-name-{{ $role->id }}">{{ $role->name }}</td>
              <td><a href="{{ route('users.index') . '?role=' . $role->id }}">Danh sách user</a></td>
              <td>
                <div class="form-group">
                  <div class="row">
                    <a class="text-primary fa fa-edit ml-2" id="edit-icon" onclick="showModalEdit({{ $role->id }})" ></a>
                    {{-- <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="fa fa-edit"></a> --}}
                    <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('{{ __('roles.delete') }}','{{ __('app.confirm') }}', {{ $role->id }})"></a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $roles->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa quyền</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <form id="updateRole">
            <label for="recipient-name" class="col-form-label">Quyền:</label>
            <input type="text" class="form-control" id="name-role-edit" name="name">
            <input type="hidden" name="id" id="id-role-edit">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="save-change">Lưu lại</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="NewRecordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm mới quyền</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <form id="storeRole">
            <label for="recipient-name" class="col-form-label">Quyền:</label>
            <input type="text" class="form-control" id="name-role-new" name="name">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="save">Lưu lại</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="{{ asset('custom/admin-role.js') }}"></script>

<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
