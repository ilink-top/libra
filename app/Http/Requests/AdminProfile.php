<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Validation\Rule;

class AdminProfile extends FormRequest
{
    public function rules()
    {
        $user = \Auth::guard(Admin::guardName())->user();
        return [
            'username' => [
                'required',
                Rule::unique(Admin::class)->ignore($user),
            ],
            'password' => ['confirmed'],
        ];
    }
}
