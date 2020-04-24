<!-- 位于 auth_permission/index.blade.php -->
@extends('layout.main')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        @if ($system['user']->can('admin.auth_permission.create'))
        {{Form::button(__('admin.new'), ['class' => 'btn btn-success modal-form', 'data-remote' => route('admin.auth_permission.create')])}}
        @endif
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="libra-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>名称</th>
              <th>路由</th>
              <th>分组</th>
              <th>创建时间</th>
              <th>修改时间</th>
              <th>操作</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    {!! Form::open(['route' => ['admin.auth_role.store'], 'class' => 'box box-primary form-horizontal', 'id' =>
    'libra-filter']) !!}
    <div class="box-header with-border">
      <h3 class="box-title">{{__('admin.filter')}}</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            {{ Form::label('filter[guard_name]', '分组', ['class' => 'col-md-1 control-label']) }}
            <div class="col-md-2">
              {{ Form::mySelect('filter[guard_name]', guards(), __('admin.all'), null, ['class' => 'form-control select2']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      {{ Form::submit(null, ['class' => 'btn btn-primary']) }}
    </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(function () {
    var table = $('#libra-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{route('admin.auth_permission.index')}}"
      },
      language: {
        searchPlaceholder: '名称/路由',
      },
      columns: [
        {
          data: 'id',
          searchable: false
        }, {
          data: 'title'
        }, {
          data: 'name'
        }, {
          data: 'guard_name',
          searchable: false
        }, {
          data: 'created_at',
          searchable: false
        }, {
          data: 'updated_at',
          searchable: false
        }, {
          data: 'action',
          sortable: false,
        }
      ]
    });

    $(document).on('submit', '#libra-form', function (e) {
      e.preventDefault();
      $(this).modalFormSubmit(function () {
        table.ajax.reload();
      })
    });

    $(document).on('submit', '#libra-filter', function (e) {
      e.preventDefault();
      table.settings()[0].ajax.data = $(this).serializeObject();
      table.ajax.reload();
    })
  });
</script>
@endpush