@extends('layouts.master')

@section('title', 'Masha life | Tất cả thông báo')
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<div style="margin-bottom: 30px;">
@include('layouts.nav-child')
</div>

    <!-- /.card-header -->
    <div class="container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('notifies.notify') }}</th>
          <th width="10%">{{ __('notifies.seen') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($notifiesUser) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($notifiesUser as $key => $notify)
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
      {{ $notifiesUser->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<!-- Modal -->

<style type="text/css">
  body {
    font-size: 15px;
  }
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
