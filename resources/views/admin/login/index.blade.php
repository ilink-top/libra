<!-- 位于 login/index.blade.php -->
@extends('layout.auth')
@section('title', '登录')
@section('body-style', 'login-page')
@section('content')
<div class="login-box">
  <div class="login-box-body">
    <div class="login-logo">
      <b>{{__('admin.system_name')}}</b>
    </div>
    {!! Form::open(['route' => ['admin.postLogin'], 'method' => 'POST']) !!}
      <div class="form-group has-feedback @error('username') has-error @enderror">
        {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('admin.username')]) }}
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @error('username')
        <span class="help-block">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group has-feedback @error('password') has-error @enderror">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('admin.password')]) }}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @error('password')
        <span class="help-block">{{$message}}</span>
        @enderror
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              {{ Form::checkbox('remember', 1, null, ['class' => 'icheck']) }} {{__('admin.remember_me')}}
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          {{ Form::submit(__('admin.login'), ['class' => 'btn btn-primary btn-block btn-flat']) }}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection