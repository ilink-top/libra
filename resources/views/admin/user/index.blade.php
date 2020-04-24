<!-- 位于 user/index.blade.php -->
@extends('layout.main')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        @if ($system['user']->can('admin.user.create'))
        {{Form::button(__('admin.new'), ['class' => 'btn btn-success modal-form', 'data-remote' => route('admin.user.create')])}}
        @endif
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="libra-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>名称</th>
              <th>邮箱</th>
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
      ajax: "{{route('admin.user.index')}}",
      language: {
        searchPlaceholder: '名称/邮箱',
      },
      columns: [
        {
          data: 'id',
          searchable: false
        }, {
          data: 'name'
        }, {
          data: 'email'
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
      $(this).ModalFormSubmit(function () {
        table.ajax.reload();
      })
    });
  });
</script>
@endpush