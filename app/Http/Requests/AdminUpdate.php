<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Validation\Rule;

class AdminUpdate extends FormRequest
{
    public function rules()
    {
        return [
            'username' => [
                'required',
                Rule::unique(Admin::class)->ignore($this->route('admin')),
            ],
            'password' => ['confirmed'],
        ];
    }
}
