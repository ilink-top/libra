<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserUpdate extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique(User::class)->ignore($this->route('user')),
            ],
            'password' => ['confirmed'],
        ];
    }
}
