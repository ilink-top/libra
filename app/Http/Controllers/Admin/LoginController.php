<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function index()
    {
        if ($this->user()) {
            return redirect()->intended($this->redirectPath());
        }

        return view('login.index');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    public function username()
    {
        return 'username';
    }

    protected function guard()
    {
        return parent::guard();
    }
}
