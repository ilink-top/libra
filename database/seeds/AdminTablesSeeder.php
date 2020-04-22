<?php

use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AuthPermission;
use App\Models\AuthRole;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Cache::forget(config('permission.cache.key'));

        \DB::table('auth_permissions')->truncate();
        \DB::table('auth_roles')->truncate();
        \DB::table('auth_role_permission')->truncate();
        \DB::table('auth_user_permission')->truncate();
        \DB::table('auth_user_role')->truncate();
        \DB::table('admins')->truncate();
        \DB::table('admin_menus')->truncate();

        $authPermissionData = [
            [
                'title' => '权限列表',
                'name' => 'admin.auth_permission.index',
            ], [
                'title' => '权限详情',
                'name' => 'admin.auth_permission.show',
            ], [
                'title' => '添加权限',
                'name' => 'admin.auth_permission.create',
            ], [
                'title' => '保存添加权限',
                'name' => 'admin.auth_permission.store',
            ], [
                'title' => '修改权限',
                'name' => 'admin.auth_permission.edit',
            ], [
                'title' => '保存修改权限',
                'name' => 'admin.auth_permission.update',
            ], [
                'title' => '删除权限',
                'name' => 'admin.auth_permission.destroy',
            ], [
                'title' => '角色列表',
                'name' => 'admin.auth_role.index',
            ], [
                'title' => '角色详情',
                'name' => 'admin.auth_role.show',
            ], [
                'title' => '添加角色',
                'name' => 'admin.auth_role.create',
            ], [
                'title' => '保存添加角色',
                'name' => 'admin.auth_role.store',
            ], [
                'title' => '修改角色',
                'name' => 'admin.auth_role.edit',
            ], [
                'title' => '保存修改角色',
                'name' => 'admin.auth_role.update',
            ], [
                'title' => '删除角色',
                'name' => 'admin.auth_role.destroy',
            ], [
                'title' => '角色权限',
                'name' => 'admin.auth_role_permission.index',
            ], [
                'title' => '保存角色权限',
                'name' => 'admin.auth_role_permission.update',
            ], [
                'title' => '管理员列表',
                'name' => 'admin.admin.index',
            ], [
                'title' => '管理员详情',
                'name' => 'admin.admin.show',
            ], [
                'title' => '添加管理员',
                'name' => 'admin.admin.create',
            ], [
                'title' => '保存添加管理员',
                'name' => 'admin.admin.store',
            ], [
                'title' => '修改管理员',
                'name' => 'admin.admin.edit',
            ], [
                'title' => '保存修改管理员',
                'name' => 'admin.admin.update',
            ], [
                'title' => '删除管理员',
                'name' => 'admin.admin.destroy',
            ], [
                'title' => '菜单列表',
                'name' => 'admin.admin_menu.index',
            ], [
                'title' => '菜单详情',
                'name' => 'admin.admin_menu.show',
            ], [
                'title' => '添加菜单',
                'name' => 'admin.admin_menu.create',
            ], [
                'title' => '保存添加菜单',
                'name' => 'admin.admin_menu.store',
            ], [
                'title' => '修改菜单',
                'name' => 'admin.admin_menu.edit',
            ], [
                'title' => '保存修改菜单',
                'name' => 'admin.admin_menu.update',
            ], [
                'title' => '删除菜单',
                'name' => 'admin.admin_menu.destroy',
            ], [
                'title' => '用户列表',
                'name' => 'admin.user.index',
            ], [
                'title' => '用户详情',
                'name' => 'admin.user.show',
            ], [
                'title' => '添加用户',
                'name' => 'admin.user.create',
            ], [
                'title' => '保存添加用户',
                'name' => 'admin.user.store',
            ], [
                'title' => '修改用户',
                'name' => 'admin.user.edit',
            ], [
                'title' => '保存修改用户',
                'name' => 'admin.user.update',
            ], [
                'title' => '删除用户',
                'name' => 'admin.user.destroy',
            ],
        ];
        foreach ($authPermissionData as $row) {
            AuthPermission::create([
                'title' => $row['title'],
                'name' => $row['name'],
                'guard_name' => 'admin',
            ]);
        }

        $authRole = AuthRole::create([
            'name' => '超级管理员',
            'guard_name' => 'admin',
        ]);
        $authRole->syncPermissions(AuthPermission::get()->pluck('id'));

        $admin = Admin::create([
            'username' => 'admin',
            'password' => 'admin',
        ]);
        $admin->syncRoles([$authRole->id]);

        $adminMenuTree = [
            [
                'icon' => 'fa-key',
                'name' => '权限管理',
                'sort' => 99,
                'children' => [
                    [
                        'name' => '权限列表',
                        'uri' => 'admin/auth_permission',
                        'sort' => 1,
                    ], [
                        'name' => '角色列表',
                        'uri' => 'admin/auth_role',
                        'sort' => 2,
                    ],
                ],
            ], [
                'icon' => 'fa-gear',
                'name' => '系统管理',
                'sort' => 100,
                'children' => [
                    [
                        'name' => '管理员列表',
                        'uri' => 'admin/admin',
                        'sort' => 1,
                    ], [
                        'name' => '管理菜单',
                        'uri' => 'admin/admin_menu',
                        'sort' => 2,
                    ],
                ],
            ], [
                'icon' => 'fa-users',
                'name' => '用户管理',
                'sort' => 90,
                'children' => [
                    [
                        'name' => '用户列表',
                        'uri' => 'admin/user',
                        'sort' => 1,
                    ],
                ],
            ],
        ];
        $this->createAdminMenu($adminMenuTree);
    }

    private function createAdminMenu($tree, $pid = 0)
    {
        foreach ($tree as $row) {
            $adminMenu = AdminMenu::create([
                'pid' => $pid,
                'icon' => $row['icon'] ?? 'fa-circle-o',
                'name' => $row['name'],
                'uri' => $row['uri'] ?? null,
                'desc' => $row['desc'] ?? null,
                'sort' => $row['sort'] ?? 10,
            ]);
            if (isset($row['children'])) {
                $this->createAdminMenu($row['children'], $adminMenu['id']);
            }
        }
    }
}
