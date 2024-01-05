<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OptionsCode;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function categoryNews(Request $request,Category $category)
    {
        $modal = $modal ?? 'all';
        $paginate = $request->has('paginate') ? $request->get('paginate') : 'all' ;
        $news_all = News::active()->latest()->with('filesAll')->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->paginate(16)->withQueryString();

        $news_premium = News::active()->latest()->premium()->with('filesAll')->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->paginate(16)->withQueryString();

        $fresh_news =  Cache::remember('fresh_news', 600, function () {
            return  News::active()->latest()->with('filesAll')->take(10)->get();
        });

        return view('frontend.pages.categories.index', compact('category','fresh_news',
            'paginate', 'news_all', 'news_premium', 'modal'));

    }
}
