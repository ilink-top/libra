<?php

namespace App\Http\Requests;

class AuthPermissionUpdate extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'name' => ['required'],
            'guard_name' => ['required'],
        ];
    }
}
