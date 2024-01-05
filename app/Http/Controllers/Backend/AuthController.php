<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('backend.login.index');
    }

    public function login(LoginRequest $request)
    {
        try
        {
            $credentials = $request->only(['email', 'password']);
            $remember    = $request->remember;

            if(auth('admin')->attempt($credentials, $remember))
            {
                return redirect(route('backend.dashboard'))->withSuccess(trans('backend.messages.success.login'));
            }

            return back()->withWarning(trans('backend.messages.warning.login'));
        }

        catch (Exception $e)
        {
            dd($e->getMessage());
            Log::channel('backend')->error($e->getMessage());
            return back()->withError(trans('backend.messages.error.login'));
        }
    }

    public function logout()
    {
        try
        {
            auth('admin')->logout();
            return redirect(route('backend.login.form'))->withSuccess(trans('backend.messages.success.logout'));
        }

        catch (Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return back()->withError(trans('backend.messages.error.logout'));
        }
    }
}
