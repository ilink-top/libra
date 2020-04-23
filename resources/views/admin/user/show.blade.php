<!-- 位于 user/show.blade.php -->
@extends('layout.mini')
@section('content')
@if (empty($info))
{!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST', 'id' => 'libra-form']) !!}
@else
{!! Form::model($info, ['route' => ['admin.user.update', $info->id], 'method' => 'PUT', 'id' => 'libra-form']) !!}
@endif
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">{{__('admin.detail')}}</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    {{ Form::label('name', '名称') }}
    {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('email', '邮箱') }}
    {{ Form::email('email', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  @if (Route::is('*.show') == false)
  <div class="form-group">
    {{ Form::label('password', '密码') }}
    {{ Form::password('password', ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('password_confirmation', '确认密码') }}
    {{ Form::password('password_confirmation', ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  @endif
</div>
<div class="modal-footer">
  @if (Route::is('*.show'))
  {{ Form::button(__('admin.close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
  @else
  {{ Form::submit(null, ['class' => 'btn btn-primary pull-left', 'disabled' => Route::is('*.show')]) }}
  {{ Form::reset(null, ['class' => 'btn btn-default', 'disabled' => Route::is('*.show')]) }}
  @endif
</div>
{!! Form::close() !!}
@endsection