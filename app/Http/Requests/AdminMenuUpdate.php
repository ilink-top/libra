<?php

namespace App\Http\Requests;

class AdminMenuUpdate extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
