<!-- 位于 auth_role/index.blade.php -->
@extends('layout.main')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        @if ($system['user']->can('admin.auth_role.create'))
        {{Form::button(__('admin.new'), ['class' => 'btn btn-success modal-form', 'data-remote' => route('admin.auth_role.create')])}}
        @endif
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="libra-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>名称</th>
              <th>分组</th>
              <th>创建时间</th>
              <th>修改时间</th>
              <th>操作</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <div class="box box-primary " id="filter">
      <div class="box-header with-border">
        <h3 class="box-title">{{__('admin.filter')}}</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          {!! Form::open(['class' => 'form-horizontal']) !!}
          <div class="col-md-12">
            <div class="form-group">
              {{ Form::label('guard_name', '分组', ['class' => 'col-md-1 control-label']) }}
              <div class="col-md-2">
                {{ Form::mySelect('guard_name', guards(), __('admin.all'), null, ['class' => 'form-control select2']) }}
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="box-footer">
        {{ Form::submit(null, ['class' => 'btn btn-primary']) }}
      </div>
    </div>
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
        url: "{{route('admin.auth_role.index')}}"
      },
      language: {
        searchPlaceholder: '名称',
      },
      columns: [
        {
          data: 'id',
          searchable: false
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

    $(document).on('click', '#libra-form .submit', function () {
      $("#libra-form").ModalFormSubmit(function () {
        table.ajax.reload();
      })
    });

    $(document).on('click', '#filter input:submit', function () {
      table.settings()[0].ajax.data = {
        filter: $("#filter form").serializeObject()
      };
      table.ajax.reload();
    })
  });
</script>
@endpush