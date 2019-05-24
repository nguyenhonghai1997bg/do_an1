@extends('admin.layouts.master')
@section('content')

<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
  .images img, .img {
    width: 50px;
    height: 80px;
    margin: 5px;
  }
  #sale {
    display: none;
  }
  .fa-times:before {
    color: white;
    display: none;
    z-index: 100;
  }
  .fa-times {
    z-index: 100;
    position: absolute;
    top: 3px;
    right: 5px;
  }
  .list-images {
    box-shadow: 0 3px 6px #777;
    overflow-x: hidden;
    position: relative;
  }
  .list-images:hover {
    box-shadow: 0 10px 15px #777;
    cursor: pointer;
  }
  .list-images:hover .fa-times:before{
    display: block;
  }
  .list-images:hover .black-box {
    margin-left: 0px;
    transition: 1s;
  }
  .black-box {
    background: black;
    position: absolute;
    top: 0px;
    left: 0px;
    height: 100%;
    width: 100%;
    opacity: 0.3;
    margin-left: -90px;
    z-index: 1;
  }
  #title {
    border-bottom: 1px solid #9999
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
          <li class="breadcrumb-item active">{{ __('products.edit') }}</li>
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
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
{!! Form::open(['method' => 'PUT', 'route' => ['products.update', 'id' => $product->id], 'files' => true]) !!}
  <div class="row col-md-12 ml-3">
    <div class="col-md-11" id="title">
      <h1>{{ __('products.edit') }}</h1>
    </div>
      <div class="col-md-6 mt-3 mb-5">
        <div class="form-group">
          <label for="name">{{ __('products.name') }}</label>
          <input type="text" name="name" class="form-control" value="{{ $product->name }}">
        </div>
        <div class="form-group">
          <label for="price">{{ __('products.price') }}</label>
          <input type="number" name="price" class="form-control" value="{{ $product->price }}">
        </div>
        <div class="form-group">
          <label for="category">{{ __('products.category') }}</label>
          <select class="form-control" name="category_id">
            <option selected value="">-- {{ __('products.categories') }} --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" @if($product->category->id == $category->id) selected @endif >{{ $category->name . ' ' . $category->catalog->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="description">{{ __('products.description') }}</label>
          <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
          <label for="detail">{{ __('products.detail') }}</label>
          <textarea name="detail" class="form-control" id="detail">{{ $product->detail }}</textarea>
        </div>
        <div class="form-group">
          <input type="submit" value="{{ __('app.edit') }}" class="btn btn-info">
        </div>
      </div>
      <div class="col-md-5 ml-2 mt-3 mb-5">
        <div class="form-group">
          <input type="file" multiple id="images-photo-add" name="images[]" accept="image/x-png,image/gif,image/jpeg">
          <div class="images"></div>
          @foreach($product->images as $image)
            <div class="float-left list-images" id="img-{{ $image->id }}">
              <img src="{{ asset('images/products/' . $image->image_url) }}" class="img">
              <i class="fa fa-times " aria-hidden="true" onclick="removeImage({{ $image->id }})"></i>
              <div class="black-box"></div>
            </div>
          @endforeach
          <div class="clearfix"></div>
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
              <input type="text" name="depot_name" class="form-control" value="{{ $product->warehouse->depot_name }}">
            </div>
            <div class="form-group">
                <label>{{ __('warehouses.quantity') }}</label>
                <input type="number" name="quantity" class="form-control" value="{{ $product->warehouse->quantity }}">
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
              <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ !empty($product->sale->sale_price) ? $product->sale->sale_price : ''  }}">
            </div>
            <div class="form-group">
                <label>{{ __('sales.description') }}</label>
                <textarea id="sale_description" name="sale_description">{{ !empty($product->sale->description) ? $product->sale->description : ''  }}</textarea>
            </div>
            <div class="form-group">
              <div class="btn btn-warning btn-sm" id="sale-hide">{{ __('sales.hide') }}</div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
  </div>
{{ Form::close() }}
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('custom/admin-product.js') }}"></script>
@endsection
