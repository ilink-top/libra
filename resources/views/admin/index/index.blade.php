<!-- 位于 index/index.blade.php -->
@extends('layout.main')
@section('title', __('admin.home'))
@section('content')
<div class="row">
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-desktop"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">操作系统</span>
        <span class="info-box-number">{{$systemInfo['os']}}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-code"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">PHP 版本</span>
        <span class="info-box-number">{{$systemInfo['php_version']}}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fa fa-upload"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">上传附件限制</span>
        <span class="info-box-number">{{$systemInfo['upload_max_filesize']}}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">执行时间限制</span>
        <span class="info-box-number">{{$systemInfo['max_execution_time']}} 秒</span>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">最近登录</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body no-padding">
        <ul class="users-list clearfix">
          @foreach($lastLoginAdmins as $admin)
          <li>
            <img src="{{asset($admin->avatar ?: 'images/avatar.png')}}" alt="User Avatar">
            <a class="users-list-name" href="#">{{$admin->username}}</a>
            <span class="users-list-date">{{$admin->logined_at}}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @if($system['user']->can('admin.admin.index'))
      <div class="box-footer text-center">
        <a href="{{url('admin/admin')}}" class="uppercase">查看所有管理员</a>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection