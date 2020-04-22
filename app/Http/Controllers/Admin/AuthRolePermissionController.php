<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuthPermission;
use App\Models\AuthRole;
use Illuminate\Http\Request;

class AuthRolePermissionController extends BaseController
{
    public function index(AuthRole $authRole)
    {
        $permissionList = AuthPermission::where('guard_name', $authRole->guard_name)->get();
        $permissionData = [];
        foreach ($permissionList as $row) {
            $nameArray = explode('.', $row->name);
            $permissionData[$nameArray[1]][] = $row;
        }
        return view('auth_role_permission.index', [
            'info' => $authRole,
            'permissionData' => $permissionData,
        ]);
    }

    public function update(Request $request, AuthRole $authRole)
    {
        $permissions = $request->input('permission_id');

        if ($authRole->syncPermissions($permissions) === false) {
            return $this->error();
        }
        return $this->success(__('admin.succeeded'), redirect()->route('admin.auth_role.index'));
    }
}
