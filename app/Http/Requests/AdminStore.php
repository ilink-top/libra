<?php

namespace App\Http\Requests;

use App\Models\Admin;

class AdminStore extends FormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'unique:' . Admin::class],
            'password' => ['required', 'confirmed'],
        ];
    }
}
