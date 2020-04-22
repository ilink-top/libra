<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Yajra\DataTables\Facades\DataTables;

class BaseController extends Controller
{
    protected $uploadPath = 'admin';

    protected function datatable($data)
    {
        return Datatables::of($data)
            ->addColumn('action', function ($model) {
                return $this->datatableAction($model);
            })
            ->make(true);
    }

    protected function success($message = '', $redirect = null)
    {
        $message = $message ? $message : __('admin.succeeded');
        if (request()->ajax()) {
            return response()->json([
                'code' => 0,
                'message' => $message,
            ]);
        }
        if (!$redirect) {
            $redirect = redirect()->back();
        }
        return $redirect
            ->with('toastr', 'success')
            ->with('message', $message);
    }

    protected function error($message = '', $redirect = null)
    {
        $message = $message ? $message : __('admin.failed');
        if (request()->ajax()) {
            return response()->json([
                'code' => 1,
                'message' => $message,
            ]);
        }
        if (!$redirect) {
            $redirect = redirect()->back();
        }
        return $redirect
            ->with('toastr', 'error')
            ->with('message', $message);
    }

    protected function guardName()
    {
        return Admin::guardName();
    }

    protected function guard()
    {
        return \Auth::guard($this->guardName());
    }

    protected function user()
    {
        return $this->guard()->user();
    }
}
