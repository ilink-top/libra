<!-- 位于 admin/show.blade.php -->
@extends('layout.mini')
@section('content')
@if (empty($info))
{!! Form::open(['route' => ['admin.admin.store'], 'method' => 'POST', 'files' => true, 'id' => 'libra-form']) !!}
@else
{!! Form::model($info, ['route' => ['admin.admin.update', $info->id], 'method' => 'PUT', 'files' => true, 'id' =>
'libra-form']) !!}
@endif
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">{{__('admin.detail')}}</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    {{ Form::label('username', '用户名') }}
    {{ Form::text('username', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
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
  <div class="form-group">
    {{ Form::label('avatar', '头像') }}
    {{ Form::myFile('avatar', null, ['disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('role_id[]', '角色') }}
    {{ Form::select('role_id[]', $roleList, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'disabled' => Route::is('*.show')]) }}
  </div>
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