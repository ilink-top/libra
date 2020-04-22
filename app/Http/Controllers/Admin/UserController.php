<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable(User::query());
        }
        return view('user.index');
    }

    protected function datatableAction(User $user)
    {
        $html = [];
        if ($this->user()->can('admin.user.show')) {
            $html[] = \Form::button(__('admin.detail'), [
                'class' => 'btn btn-xs btn-default modal-form',
                'data-remote' => route('admin.user.show', $user->id),
            ]);
        }
        if ($this->user()->can('admin.user.edit')) {
            $html[] = \Form::button(__('admin.edit'), [
                'class' => 'btn btn-xs btn-primary modal-form',
                'data-remote' => route('admin.user.edit', $user->id),
            ]);
        }
        if ($this->user()->can('admin.user.destroy')) {
            $html[] = \Form::button(__('admin.delete'), [
                'class' => 'btn btn-xs btn-danger modal-delete',
                'data-remote' => route('admin.user.destroy', $user->id),
            ]);
        }
        return !empty($html) ? implode($html, PHP_EOL) : '无权限';
    }

    public function create()
    {
        return view('user.show');
    }

    public function store(UserStore $request)
    {
        $input = $request->all();

        if (User::create($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.save_succeeded'), redirect()->route('admin.user.index'));
    }

    public function show(User $user)
    {
        return view('user.show', [
            'info' => $user,
        ]);
    }

    public function edit(User $user)
    {
        return view('user.show', [
            'info' => $user,
        ]);
    }

    public function update(UserUpdate $request, User $user)
    {
        $input = $request->all();

        if ($user->update($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'), redirect()->route('admin.user.index'));
    }

    public function destroy(User $user)
    {
        if ($user->delete() === false) {
            return $this->error();
        }
        return $this->success(__('admin.delete_succeeded'), redirect()->route('admin.user.index'));
    }
}
