<?php

namespace App\Http\Requests;

class AuthRoleUpdate extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'guard_name' => ['required'],
        ];
    }
}
