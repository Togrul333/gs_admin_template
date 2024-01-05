<?php

namespace App\Http\Middleware;

use App\Models\News;
use App\Models\View;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViewMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $model_type)
    {
        $model = News::whereHas('translations', function ($query) use ($request) {
            $query->where('slug', $request->slug);
        })->firstOrFail();
        if (auth()->check()) {
            $viewer = auth()->user()->id;
            $viewExists = View::where('viewer_id', $viewer)
                ->where('viewable_id', $model->id)
                ->where('viewable_type', $model_type)
                ->exists();
            if (!$viewExists) {
                $model->views()->create([
                    'viewer_id' => $viewer
                ]);
            }
        }else{
            $viewExists = View::where('viewer_id', null)
                ->where('ip', $request->ip())
                ->where('viewable_id', $model->id)
                ->where('viewable_type', $model_type)
                ->exists();

            if (!$viewExists) {
                $model->views()->create([
                    'viewer_id' => null,
                    'ip' => $request->ip() ?? ""
                ]);
            }

        }
        return $next($request);
    }
}
