<?php

namespace App\Http\Requests;

use App\Models\User;

class UserStore extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ];
    }
}
