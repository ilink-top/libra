<!-- 位于 profile/index.blade.php -->
@extends('layout.main')
@section('title', __('admin.user_setting'))
@section('bread')
<li class="active"><i class="fa fa-user"></i> {{__('admin.user_setting')}}</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      {!! Form::model($info, ['route' => ['admin.profile.update', $info->id], 'method' => 'POST', 'class' =>
      'form-horizontal']) !!}
      <div class="box-header"></div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group @error('username') has-error @enderror">
              {{ Form::label('username', '用户名', ['class' => 'col-md-2 control-label']) }}
              <div class="col-md-6">
                {{ Form::text('username', null, ['class' => 'form-control']) }}
              </div>
              <div class="col-md-4">
                @error('username')
                <span class="help-block">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="form-group @error('password') has-error @enderror">
              {{ Form::label('password', '密码', ['class' => 'col-md-2 control-label']) }}
              <div class="col-md-6">
                {{ Form::password('password', ['class' => 'form-control']) }}
              </div>
              <div class="col-md-4">
                @error('password')
                <span class="help-block">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="form-group @error('password_confirmation') has-error @enderror">
              {{ Form::label('password_confirmation', '确认密码', ['class' => 'col-md-2 control-label']) }}
              <div class="col-md-6">
                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
              </div>
              <div class="col-md-4">
                @error('password_confirmation')
                <span class="help-block">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="form-group @error('avatar') has-error @enderror">
              {{ Form::label('avatar', '头像', ['class' => 'col-md-2 control-label']) }}
              <div class="col-md-6">
                {{ Form::myFile('avatar') }}
              </div>
              <div class="col-md-4">
                @error('avatar')
                <span class="help-block">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-md-6 col-md-offset-2">
            {{ Form::submit(null, ['class' => 'btn btn-primary']) }}
            {{ Form::reset(null, ['class' => 'btn btn-default pull-right']) }}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection