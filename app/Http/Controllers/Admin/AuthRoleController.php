<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthRoleUpdate;
use App\Models\AuthRole;
use Illuminate\Http\Request;

class AuthRoleController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter = $request->filter;
            $map = AuthRole::getMap($filter);
            return $this->datatable(AuthRole::where($map));
        }
        return view('auth_role.index');
    }

    protected function datatableAction(AuthRole $authRole)
    {
        $html = [];
        if ($this->user()->can('admin.auth_role.show')) {
            $html[] = \Form::button(__('admin.detail'), [
                'class' => 'btn btn-xs btn-default modal-form',
                'data-remote' => route('admin.auth_role.show', $authRole->id),
            ]);
        }
        if ($this->user()->can('admin.auth_role.edit')) {
            $html[] = \Form::button(__('admin.edit'), [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.auth_role.edit', $authRole->id),
            ]);
        }
        if ($this->user()->can('admin.auth_role.destroy')) {
            $html[] = \Form::button(__('admin.delete'), [
                'class' => 'btn btn-xs btn-danger modal-delete',
                'data-remote' => route('admin.auth_role.destroy', $authRole->id),
            ]);
        }
        if ($this->user()->can('admin.auth_role_permission.index')) {
            $html[] = \Form::button('权限', [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.auth_role_permission.index', $authRole->id),
            ]);
        }
        return !empty($html) ? implode($html, PHP_EOL) : '无权限';
    }

    public function create()
    {
        return view('auth_role.show');
    }

    public function store(AuthRoleUpdate $request)
    {
        if (AuthRole::create($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.save_succeeded'), redirect()->route('admin.auth_role.index'));
    }

    public function show(AuthRole $authRole)
    {
        return view('auth_role.show', [
            'info' => $authRole,
        ]);
    }

    public function edit(AuthRole $authRole)
    {
        return view('auth_role.show', [
            'info' => $authRole,
        ]);
    }

    public function update(AuthRoleUpdate $request, AuthRole $authRole)
    {
        $input = $request->all();

        if ($authRole->update($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'), redirect()->route('admin.auth_role.index'));
    }

    public function destroy(AuthRole $authRole)
    {
        if ($authRole->delete() === false) {
            return $this->error();
        }
        return $this->success(__('admin.delete_succeeded'), redirect()->route('admin.auth_role.index'));
    }
}
