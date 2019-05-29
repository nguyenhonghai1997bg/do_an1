@extends('admin.layouts.master')

@section('title', __('app.add'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('users.create') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row ml-3">
  <div class="col-12">
    <div class="col-md-10">
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
      @endif
    </div>
    {!! Form::open(['url' => route('users.store')]) !!}
      <div class="form-group">
        <div class="col-md-10">
          <div class="col-md-2">
            <label>{{ __('users.name') }}</label>
          </div>
          <div class="col-md-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-address-book" aria-hidden="true"></i></span>
              </div>
              <input type="text" name="name" placeholder="{{ __('users.name') }}" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-10">
          <div class="col-md-2">
            <label>{{ __('users.email') }}</label>
          </div>
          <div class="col-md-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
              </div>
              <input type="email" name="email" placeholder="{{ __('users.email') }}" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-10">
          <div class="col-md-2">
            <label>{{ __('users.address') }}</label>
          </div>
          <div class="col-md-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-address-card"></i></span>
              </div>
              <input type="text" name="address" placeholder="{{ __('users.address') }}" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-10">
          <div class="col-md-2">
            <label>{{ __('users.phone') }}</label>
          </div>
          <div class="col-md-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-phone"></i></span>
              </div>
              <input type="text" class="form-control" placeholder="{{ __('users.phone') }}" name="phone" data-inputmask='"mask": "(999) 999-9999"' data-mask>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-10">
          <div class="col-md-2">
            <label>{{ __('users.role') }}</label>
          </div>
          <div class="col-md-10">
            <select class="form-control" name="role_id">
              <option selected>-- {{ __('users.role') }} --</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="form-group ml-3">
      <input type="submit" value="{{ __('users.create') }}" class="btn btn-info">
        <a href="{{ url()->previous() }}" class="btn btn-default">{{ __('app.back') }}</a>
      </div>
    {{ Form::close() }}
  </div>
</div>
@endsection
