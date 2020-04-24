<!-- 位于 admin_menu/show.blade.php -->
@extends('layout.mini')
@section('content')
@if (empty($info))
{!! Form::open(['route' => ['admin.admin_menu.store'], 'method' => 'POST', 'id' => 'libra-form']) !!}
@else
{!! Form::model($info, ['route' => ['admin.admin_menu.update', $info->id], 'method' => 'PUT', 'id' => 'libra-form']) !!}
@endif
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">{{__('admin.detail')}}</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    {{ Form::label('pid', '上级') }}
    {{ Form::mySelect('guard_name', $menuData, __('admin.top'), null, ['class' => 'form-control select2', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('name', '名称') }}
    <div class="input-group">
      {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
      @if (!Route::is('*.show'))
      {{ Form::hidden('icon', null, ['class' => 'form-control icp']) }}
      @endif
      <span class="input-group-addon">
        @if (!empty($info))
        <i class="fa {{$info->icon}}"></i>
        @endif
      </span>
    </div>
  </div>
  <div class="form-group">
    {{ Form::label('uri', '链接') }}
    {{ Form::text('uri', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('desc', '描述') }}
    {{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 3, 'disabled' => Route::is('*.show')]) }}
  </div>
  <div class="form-group">
    {{ Form::label('sort', '排序') }}
    {{ Form::text('sort', null, ['class' => 'form-control', 'disabled' => Route::is('*.show')]) }}
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