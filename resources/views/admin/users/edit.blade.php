@extends('admin.layouts.master')

@section('title', __('users.edit'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('users.edit') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row">
  <div class="col-12">
    <div class="col-md-10">
      <div class="col-md-2">
        <label>Role</label>
      </div>
      <div class="col-md-10">
        <form>
          <input type="text" name="name" placeholder="Enter role" class="form-control">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
