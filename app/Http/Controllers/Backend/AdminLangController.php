<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminLangController extends Controller
{
    public function __invoke()
    {
        try
        {
            $code = app()->getLocale() == 'az' ? 'en' : 'az';

            app()->setlocale($code);
            Session::put('locale', $code);

            return back()->withSuccess(trans('backend.messages.success.lang'));
        }

        catch (Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return back()->withError(trans('backend.messages.error.lang'));
        }
    }
}
