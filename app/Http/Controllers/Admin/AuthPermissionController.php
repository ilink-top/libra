<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthPermissionUpdate;
use App\Models\AuthPermission;
use Illuminate\Http\Request;

class AuthPermissionController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter = $request->filter;
            $map = AuthPermission::getMap($filter);
            return $this->datatable(AuthPermission::where($map));
        }
        return view('auth_permission.index');
    }

    protected function datatableAction(AuthPermission $authPermission)
    {
        $html = [];
        if ($this->user()->can('admin.auth_permission.show')) {
            $html[] = \Form::button(__('admin.detail'), [
                'class' => 'btn btn-xs btn-default modal-form',
                'data-remote' => route('admin.auth_permission.show', $authPermission->id),
            ]);
        }
        if ($this->user()->can('admin.auth_permission.edit')) {
            $html[] = \Form::button(__('admin.edit'), [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.auth_permission.edit', $authPermission->id),
            ]);
        }
        if ($this->user()->can('admin.auth_permission.destroy')) {
            $html[] = \Form::button(__('admin.delete'), [
                'class' => 'btn btn-xs btn-danger modal-delete',
                'data-remote' => route('admin.auth_permission.destroy', $authPermission->id),
            ]);
        }
        return !empty($html) ? implode($html, PHP_EOL) : '无权限';
    }

    public function create()
    {
        return view('auth_permission.show');
    }

    public function store(AuthPermissionUpdate $request)
    {
        $input = $request->all();

        if (AuthPermission::create($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.save_succeeded'), redirect()->route('admin.auth_permission.index'));
    }

    public function show(AuthPermission $authPermission)
    {
        return view('auth_permission.show', [
            'info' => $authPermission,
        ]);
    }

    public function edit(AuthPermission $authPermission)
    {
        return view('auth_permission.show', [
            'info' => $authPermission,
        ]);
    }

    public function update(AuthPermissionUpdate $request, AuthPermission $authPermission)
    {
        $input = $request->all();

        if ($authPermission->update($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'), redirect()->route('admin.auth_permission.index'));
    }

    public function destroy(AuthPermission $authPermission)
    {
        if ($authPermission->delete() === false) {
            return $this->error();
        }
        return $this->success(__('admin.delete_succeeded'), redirect()->route('admin.auth_permission.index'));
    }
}
