<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminStore;
use App\Http\Requests\AdminUpdate;
use App\Models\Admin;
use App\Models\AuthRole;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable(Admin::query());
        }
        return view('admin.index');
    }

    protected function datatableAction(Admin $admin)
    {
        $html = [];
        if ($this->user()->can('admin.admin.show')) {
            $html[] = \Form::button(__('admin.detail'), [
                'class' => 'btn btn-xs btn-default modal-form',
                'data-remote' => route('admin.admin.show', $admin->id),
            ]);
        }
        if ($this->user()->can('admin.admin.edit')) {
            $html[] = \Form::button(__('admin.edit'), [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.admin.edit', $admin->id),
            ]);
        }
        if ($this->user()->can('admin.admin.destroy')) {
            $html[] = \Form::button(__('admin.delete'), [
                'class' => 'btn btn-xs btn-danger modal-delete',
                'data-remote' => route('admin.admin.destroy', $admin->id),
            ]);
        }
        return !empty($html) ? implode($html, PHP_EOL) : '无权限';
    }

    public function create()
    {
        return view('admin.show', [
            'roleList' => AuthRole::getData([
                ['guard_name', '=', $this->guardName()],
            ]),
        ]);
    }

    public function store(AdminStore $request)
    {
        $input = $request->all();

        $result = \DB::transaction(function () {
            $admin = Admin::create($input);
            $admin->syncRoles($input['role_id']);
        });
        if ($result === false) {
            return $this->error();
        }
        return $this->success(__('admin.save_succeeded'), redirect()->route('admin.admin.index'));
    }

    public function show(Admin $admin)
    {
        return view('admin.show', [
            'info' => $admin,
            'roleList' => AuthRole::getData([
                ['guard_name', '=', $this->guardName()],
            ]),
        ]);
    }

    public function edit(Admin $admin)
    {
        return view('admin.show', [
            'info' => $admin,
            'roleList' => AuthRole::getData([
                ['guard_name', '=', $this->guardName()],
            ]),
        ]);
    }

    public function update(AdminUpdate $request, Admin $admin)
    {
        $input = $request->all();

        $result = \DB::transaction(function () use ($admin, $input) {
            $admin->update($input);
            $admin->syncRoles($input['role_id']);
        });
        if ($result === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'), redirect()->route('admin.admin.index'));
    }

    public function destroy(Admin $admin)
    {
        if ($admin->delete() === false) {
            return $this->error();
        }
        return $this->success(__('admin.delete_succeeded'), redirect()->route('admin.admin.index'));
    }
}
