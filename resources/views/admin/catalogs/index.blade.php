@extends('admin.layouts.master')

@section('title', __('app.catalogs'))
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
          <li class="breadcrumb-item active">{{ __('catalogs.lists') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="btn btn-success mb-3" id="new-record">{{ __('app.new') }}</div>
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('catalogs.lists') }}</h3>
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
          <th>{{ __('catalogs.name') }}</th>
          <th>{{ __('catalogs.categories') }}</th>
          <th width="10%">{{ __('app.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($catalogs) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($catalogs as $key => $catalog)
            <tr id="column-{{ $catalog->id }}">
              <td>{{ app('request')->input('page') ? \App\Catalog::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td id="name-{{ $catalog->id }}">{{ $catalog->name }}</td>
              <td><a href="{{ route('categories.index') . '?catalog=' . $catalog->id }}">{{ __('catalogs.categories') }}</a></td>
              <td>
                <div class="form-group">
                  <div class="row">
                    <a class="text-primary fa fa-edit ml-2" id="edit-icon" onclick="showModalEdit({{ $catalog->id }})" ></a>
                    <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('{{ __('catalog.delete') }}','{{ __('app.confirm') }}', {{ $catalog->id }})"></a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $catalogs->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" catalog="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" catalog="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('app.edit') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <form id="update-form">
            <label for="recipient-name" class="col-form-label">{{ __('catalogs.name') }}:</label>
            <input type="text" class="form-control" id="name-edit" name="name">
            <input type="hidden" name="id" id="id-edit">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
        <button type="button" class="btn btn-primary" id="save-change">{{ __('app.save') }}</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="NewRecordModal" tabindex="-1" catalog="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" catalog="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('app.add') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <form id="store">
            <label for="recipient-name" class="col-form-label">{{ __('catalogs.name') }}:</label>
            <input type="text" class="form-control" id="name-new" name="name">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
        <button type="button" class="btn btn-primary" id="save">{{ __('app.save') }}</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="{{ asset('custom/admin-catalog.js') }}"></script>

<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
