@extends('admin.layouts.master')
@section('content')

<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
  .images img {
    width: 50px;
    height: 80px;
    margin: 5px;
  }
  #sale {
    display: none;
  }
</style>
<section class="content-header ml-2">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('products.create') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@if(count($errors->all()) > 0)
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
{!! Form::open(['method' => 'POST', 'route' => 'products.store', 'files' => true]) !!}
  <div class="row col-md-12 ml-3">
    <div class="col-md-8" style="border-bottom: 1px solid #9999">
      <h1>{{ __('products.create') }}</h1>
    </div>
    {{-- <form> --}}
      <div class="col-md-6 mt-3 mb-5">
        <div class="form-group">
          <label for="name">{{ __('products.name') }}</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="price">{{ __('products.price') }}</label>
          <input type="number" name="price" class="form-control">
        </div>
        <div class="form-group">
          <label for="category">{{ __('products.category') }}</label>
          <select class="form-control" name="category_id">
            <option selected value="">-- {{ __('products.categories') }} --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name . ' ' . $category->catalog->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="description">{{ __('products.description') }}</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="detail">{{ __('products.detail') }}</label>
          <textarea name="detail" class="form-control" id="detail"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" value="{{ __('app.new') }}" class="btn btn-info">
        </div>
      </div>
      <div class="col-md-5 ml-2 mt-3 mb-5">
        <div class="form-group">
          <input type="file" multiple id="images-photo-add" name="images[]" accept="image/x-png,image/gif,image/jpeg">
          <div class="images"></div>
        </div>
        {{-- warehouse --}}
        <div class="card card-default mt-4">
          <div class="card-header">
            <h3 class="card-title">{{ __('app.warehouse') }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="form-group">
              <label>{{ __('warehouses.depot_name') }}</label>
              <input type="text" name="depot_name" class="form-control">
            </div>
            <div class="form-group">
                <label>{{ __('warehouses.quantity') }}</label>
                <input type="number" name="quantity" class="form-control">
            </div>
          </div>
        </div>
        {{-- sale --}}
        <div class="btn btn-success btn-sm" id="sale-add">{{ __('sales.add') }}</div>
        <div class="card card-default mt-4" id="sale">
          <div class="card-header">
            <h3 class="card-title">{{ __('app.sale') }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="form-group">
              <label>{{ __('sales.price') }}</label>
              <input type="number" name="sale_price" id="sale_price" class="form-control">
            </div>
            <div class="form-group">
                <label>{{ __('sales.description') }}</label>
                <textarea id="sale_description" name="sale_description"></textarea>
            </div>
            <div class="form-group">
              <div class="btn btn-warning btn-sm" id="sale-hide">{{ __('sales.hide') }}</div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    {{-- </form> --}}
  </div>
{{ Form::close() }}
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('custom/admin-product.js') }}"></script>
@endsection
