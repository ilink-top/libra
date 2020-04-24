<!-- 位于 admin_menu/index.blade.php -->
@extends('layout.main')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        @if ($system['user']->can('admin.admin_menu.create'))
        {{Form::button(__('admin.new'), ['class' => 'btn btn-success modal-form', 'data-remote' => route('admin.admin_menu.create')])}}
        @endif
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="libra-table">
          <thead>
            <tr>
              <th>名称</th>
              <th>链接</th>
              <th>描述</th>
              <th>排序</th>
              <th>创建时间</th>
              <th>修改时间</th>
              <th>操作</th>
            </tr>
          </thead>
        </table>
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
      paging: false,
      ordering: false,
      searching: false,
      ajax: "{{route('admin.admin_menu.index')}}",
      columns: [
        {
          data: 'name',
          render: function (data, type, row) {
            return '<i class="fa ' + row.icon + '"></i> ' + row.name;
          }
        }, {
          data: 'uri'
        }, {
          data: 'desc'
        }, {
          data: 'sort'
        }, {
          data: 'created_at'
        }, {
          data: 'updated_at'
        }, {
          data: 'action'
        }
      ],
      rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        let rowClass = 'treegrid-' + aData.id
        if (aData.pid) {
          rowClass += ' treegrid-parent-' + aData.pid;
        }
        $(nRow).attr('class', rowClass)
      },
      drawCallback: function (oSettings, json) {
        $('#libra-table').treegrid();
      }
    });

    $(document).on('submit', '#libra-form', function (e) {
      e.preventDefault();
      $(this).ModalFormSubmit(function () {
        table.ajax.reload();
      })
    });
  });
</script>
@endpush