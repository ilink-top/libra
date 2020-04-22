<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminMenuUpdate;
use App\Models\AdminMenu;
use Illuminate\Http\Request;

class AdminMenuController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable(AdminMenu::getTreeList());
        }
        return view('admin_menu.index');
    }

    protected function datatableAction(AdminMenu $AdminMenu)
    {
        $html = [];
        if ($this->user()->can('admin.admin_menu.show')) {
            $html[] = \Form::button(__('admin.detail'), [
                'class' => 'btn btn-xs btn-default modal-form',
                'data-remote' => route('admin.admin_menu.show', $AdminMenu->id),
            ]);
        }
        if ($this->user()->can('admin.admin_menu.edit')) {
            $html[] = \Form::button(__('admin.edit'), [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.admin_menu.edit', $AdminMenu->id),
            ]);
        }
        if ($this->user()->can('admin.admin_menu.destroy')) {
            $html[] = \Form::button(__('admin.delete'), [
                'class' => 'btn btn-xs btn-danger modal-delete',
                'data-remote' => route('admin.admin_menu.destroy', $AdminMenu->id),
            ]);
        }
        return !empty($html) ? implode($html, PHP_EOL) : '无权限';
    }

    public function create()
    {
        return view('admin_menu.show', [
            'menuData' => AdminMenu::getTreeData(),
        ]);
    }

    public function store(AdminMenuUpdate $request)
    {
        $input = $request->all();

        if (AdminMenu::create($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.save_succeeded'), redirect()->route('admin.admin_menu.index'));
    }

    public function show(AdminMenu $AdminMenu)
    {
        return view('admin_menu.show', [
            'info' => $AdminMenu,
            'menuData' => AdminMenu::getTreeData(),
        ]);
    }

    public function edit(AdminMenu $AdminMenu)
    {
        return view('admin_menu.show', [
            'info' => $AdminMenu,
            'menuData' => AdminMenu::getTreeData(),
        ]);
    }

    public function update(AdminMenuUpdate $request, AdminMenu $AdminMenu)
    {
        $input = $request->all();

        if ($AdminMenu->update($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'), redirect()->route('admin.admin_menu.index'));
    }

    public function destroy(AdminMenu $AdminMenu)
    {
        if ($AdminMenu->delete() === false) {
            return $this->error();
        }
        return $this->success(__('admin.delete_succeeded'), redirect()->route('admin.admin_menu.index'));
    }
}
