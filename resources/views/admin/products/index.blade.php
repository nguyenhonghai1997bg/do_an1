@extends('admin.layouts.master')
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
          <li class="breadcrumb-item active">{{ __('products.lists') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  <a href="{{ route('products.create') }}" class="btn btn-success mb-3">{{ __('app.new') }}</a>
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('products.lists') }}</h3>
    <div class="card-tools">
      {{ Form::open(['method' => 'GET' ]) }}
        <div class="input-group input-group-sm">
          <label class="mr-2">{{ __('products.category') }}:</label>
          <select class="form-control mr-4" name="category" id="categories">
            <option selected value="">-- {{ __('products.category') }} --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->name . ' ' . $category->catalog->name }}</option>
            @endforeach
          </select>
          <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $key ?? '' }}" id="search">
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
          <th>{{ __('products.name') }}</th>
          <th>{{ __('products.price') }}</th>
          <th>{{ __('products.image') }}</th>
          <th>{{ __('products.category') }}</th>
          <th>{{ __('products.status') }}</th>
          <th width="10%">{{ __('app.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($products) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($products as $key => $product)
            <tr id="column-{{ $product->id }}">
              <td>{{ app('request')->input('page') ? \App\Category::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->price }}</td>
              <td><img src="{{ asset('images/products/' . $product->images->first()->image_url) }}" width="40px" onclick="zoomImage({{ $product->id }})" class="img-product" id="image-{{ $product->id }}" data-toggle="modal" data-target="#showImage"></td>
              <td>{{ $product->category->name }}</td>
              <td>
                <input type="checkbox" @if($product->status == 1) checked @endif data-toggle="toggle" id="status-{{ $product->id }}" onchange="changeProduct({{ $product->id }})">
              </td>
              <td>
                <a class="text-primary fa fa-edit ml-2" id="edit-icon" href="{{ route('products.edit', ['id' => $product->id]) }}"></a>
                <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('{{ __('products.delete') }}','{{ __('app.confirm') }}', {{ $product->id }})"></a>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $products->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
<!-- Modal -->
<div class="modal fade" id="showImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('products.showImage') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" id="show-images" width="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="{{ asset('custom/admin-product.js') }}"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
  $('#categories').change(function() {
    var category_id = $(this).val();
    var search = $('#search').val();
    if (search) {
      window.location.href = window.location.origin + '/admin/manager/products?category=' + category_id + '&search=' + search;
    } else {
      window.location.href = window.location.origin + '/admin/manager/products?category=' + category_id;
    }
  })
  function zoomImage(id) {
    var url = $('#image-' + id).attr('src');
    $('#show-images').attr('src', url)
  }
  function changeProduct(id) {
    var status = $('#status-' + id).prop('checked') == true ? 1 : 0;
    $.ajax({
      url: window.location.origin + '/admin/manager/products/' + id + '/change-status',
      method: 'POST',
      data: {
        status: status
      },
      success: function (data) {
      },
      errors: function (errors) {
      }
    })
  }
</script>
<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
  .img-product {
    cursor: pointer;
  }
</style>
@endsection
