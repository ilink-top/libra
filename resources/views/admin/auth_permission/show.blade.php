<!-- 位于 auth_permission/show.blade.php -->
@extends('layout.mini')
@section('content')
@if (empty($info))
{!! Form::open(['route' => ['admin.auth_permission.store'], 'method' => 'POST', 'id' => 'libra-form']) !!}
@else
{!! Form::model($info, ['route' => ['admin.auth_permission.update', $info->id], 'method' => 'PUT', 'id' => 'libra-form']) !!}
@endif
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">{{__('admin.detail')}}</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    {{ Form::label('title', '名称') }}
    {{ Form::text('title', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('name', '路由') }}
    {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('guard_name', '分组') }}
    {{ Form::mySelect('guard_name', guards(), __('admin.choose'), null, ['class' => 'form-control select2', 'disabled' => Route::is('*.show')]) }}
  </div>
</div>
<div class="modal-footer">
  @if (Route::is('*.show'))
  {{ Form::button(__('admin.close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
  @else
  {{ Form::button(__('admin.submit'), ['class' => 'btn btn-primary pull-left submit', 'disabled' => Route::is('*.show')]) }}
  {{ Form::reset(null, ['class' => 'btn btn-default', 'disabled' => Route::is('*.show')]) }}
  @endif
</div>
{!! Form::close() !!}
@endsection