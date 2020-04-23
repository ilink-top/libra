<!-- 位于 auth_role_permission/index.blade.php -->
@extends('layout.mini')
@section('content')
{!! Form::model($info, ['route' => ['admin.auth_role_permission.update', $info->id], 'method' => 'POST', 'id' => 'libra-form']) !!}
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">{{__('admin.detail')}}</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    @foreach ($permissionData as $list)
    <div class="row">
      @foreach ($list as $row)
      <div class="col-md-4">
        <label>
          {{ Form::checkbox('permission_id[]', $row->id, $info->permission_id->contains($row->id), ['class' => 'icheck']) }}
          {{$row->title}}
        </label>
      </div>
      @endforeach
    </div>
    @endforeach
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