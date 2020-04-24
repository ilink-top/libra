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

    protected function authenticated(Request $request, $user)
    {
        $user->updateLoginTime();
        return $request->wantsJson()
        ? new Response('', 204)
        : redirect()->intended($this->redirectPath());
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
        return admin_guard();
    }
}
