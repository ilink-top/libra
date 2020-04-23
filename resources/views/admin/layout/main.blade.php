<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{__('admin.system_name')}} | @section('title') {{$system['title']}} @show</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <link rel="stylesheet" href="{{mix('css/admin.css')}}">
  @stack('styles')
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="{{route('admin.home')}}" class="logo">
        <span class="logo-mini"><b><i class="fa fa-dashboard"></i></b></span>
        <span class="logo-lg"><b>{{__('admin.system_name')}}</b></span>
      </a>
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{asset($system['user']->avatar ?: 'images/avatar.png')}}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{$system['user']->username}}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="{{asset($system['user']->avatar ?: 'images/avatar.png')}}" class="img-circle" alt="User Image">
                  <p>
                    {{$system['user']->username}}
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{route('admin.profile.index')}}"
                      class="btn btn-default btn-flat">{{__('admin.user_setting')}}</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{route('admin.logout')}}" class="btn btn-default btn-flat">{{__('admin.logout')}}</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{asset($system['user']->avatar ?: 'images/avatar.png')}}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{$system['user']->username}}</p>
          </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header" id="menu">{{__('admin.menu')}}</li>
          {{$system['menu']}}
        </ul>
      </section>
    </aside>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          @section('title')
          {{$system['title']}}
          @show
          <small>
            @section('desc')
            {{$system['desc']}}
            @show
          </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> {{__('admin.home')}}</a></li>
          @foreach ($system['bread'] as $row)
          <li class="active"><i class="fa {{$row->icon}}"></i> {{$row->name}}</li>
          @endforeach
        </ol>
      </section>
      <section class="content container-fluid">
        @yield('content')
      </section>
    </div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        {{__('admin.footer')}}
      </div>
      {!!__('admin.copyright')!!}
    </footer>
    <div class="modal modal-default fade" id="modal-form">
      <div class="modal-dialog">
        <div class="modal-content"></div>
      </div>
    </div>
    {!! Form::open(['method' => 'delete', 'class' => 'modal modal-default fade', 'id' => 'modal-delete']) !!}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="{{__('admin.close')}}">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{__('admin.delete')}}</h4>
        </div>
        <div class="modal-body">
          <p>{{__('admin.delete_confirm')}}</p>
        </div>
        <div class="modal-footer">
          {{ Form::submit(null, ['class' => 'btn btn-primary pull-left save']) }}
          {{ Form::button(__('admin.cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  <script src="{{mix('js/bootstrap.js')}}"></script>
  <script src="{{mix('js/admin.js')}}"></script>
  <script>
    var setting = {
      toastr: {
        type: "{{session('toastr')}}",
        message: "{{session('message')}}",
      }
    }
  </script>
  @stack('scripts')
</body>

</html>