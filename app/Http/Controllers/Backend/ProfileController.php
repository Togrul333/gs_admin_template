<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProfileRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function profileForm()
    {
        return view('backend.profile.index');
    }

    public function profile(ProfileRequest $request)
    {
        try
        {
            admin()->update($request->all());
            return redirect(route('backend.dashboard'))->withSuccess(trans('backend.messages.success.profile'));
        }

        catch (Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return redirect(route('backend.dashboard'))->withError(trans('backend.messages.error.profile'));
        }
    }
}
