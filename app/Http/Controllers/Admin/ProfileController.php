<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminProfile;

class ProfileController extends BaseController
{
    public function index()
    {
        return view('profile.index', [
            'info' => $this->user(),
        ]);
    }

    public function update(AdminProfile $request)
    {
        $user = $this->user();

        $input = $request->all();

        if ($user->update($input) === false) {
            return $this->error();
        }
        return $this->success(__('admin.update_succeeded'));
    }
}
