<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OptionsCode;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $news_all = News::active()->with('filesAll')->filterBy($request->all())->paginate(12)->withQueryString();
        $fresh_news =  Cache::remember('fresh_news', 600, function () {
            return  News::active()->latest()->with('filesAll')->take(10)->get();
        });
        return view('frontend.pages.search.index',compact('news_all','fresh_news'));
    }
}
