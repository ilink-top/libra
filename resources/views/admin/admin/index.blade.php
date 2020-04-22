<!-- 位于 admin/index.blade.php -->
@extends('layout.main')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        @if ($system['user']->can('admin.admin.create'))
        {{Form::button(__('admin.new'), ['class' => 'btn btn-success modal-form', 'data-remote' => route('admin.admin.create')])}}
        @endif
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="libra-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>用户名</th>
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
      ajax: "{{route('admin.admin.index')}}",
      language: {
        searchPlaceholder: '用户名',
      },
      columns: [
        {
          data: 'id',
          searchable: false
        }, {
          data: 'username'
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
  });
</script>
@endpush