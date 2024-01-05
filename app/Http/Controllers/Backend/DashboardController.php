<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Package;
use App\Models\Writer;
use App\Models\Writing;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $counts = Cache::rememberForever('counts', function () {
            return [
//                'news' => News::count(),
            ];
        });

        return view('backend.dashboard.index');

    }
}
