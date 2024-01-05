<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormNewsRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\Language;
use App\Models\News;
use App\Models\Option;
use App\Services\NewsService;
use App\Services\UploadImagesService;
use App\Services\UploadMediaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('news index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $news = News::query();
        if (request()->ajax())
        {
            $limit = request('length');
            $start = request('start');
            $count = News::count();
            $data = $news->latest()->offset($start)->limit($limit)->get();

            return $this->dataTable($data, $count);
        }
        return view('backend.news.index');
    }

    public function create()
    {
        abort_if(Gate::denies('news create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        $langs = Language::active()->get();
        $categories = Category::get();
        $options = Option::get();

        $files = Document::whereNull('parent_id')->unique()->paginate(12)->withQueryString();

        return view('backend.news.form', compact('edit', 'langs', 'categories', 'options', 'files'));
    }

    public function store(FormNewsRequest $request, NewsService $newsService, UploadImagesService $uploadImagesService,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('news create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        dd($request->validated());
        try {
            $newsService->create($request->validated());

            if ($request->has('selectedFiles'))
                $uploadImagesService->attachImages('news', $newsService->news->id, $request->get('selectedFiles'));

            if ($request->hasFile('image'))
                $uploadImagesService->upload('news', 'image', $newsService->news->id, true, $request);

            if ($request->hasFile('video'))
                $mediaService->upload('news', 'video', $newsService->news->id, '', true, $request);

            return redirect(route('backend.news.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error.create'));
        }
    }

    public function show(News $news): View
    {
        abort_if(Gate::denies('news index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        abort_if(Gate::denies('news edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        $langs = Language::active()->get();
        $categories = Category::get();
        $options = Option::get();
        $files = Document::whereNull('parent_id')->unique()->paginate(12)->withQueryString();

        return view('backend.news.form', compact('news', 'edit', 'langs', 'categories', 'options', 'files'));
    }

    public function update(FormNewsRequest $request, News $news, NewsService $newsService, UploadImagesService $uploadImagesService,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('news edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $data = $request->validated();
            $data['news'] = $news;
            $newsService->update($data);

            if ($request->has('selectedFiles'))
                $uploadImagesService->attachImages('news', $newsService->news->id, $request->get('selectedFiles'));

            if ($request->hasFile('image'))
                $uploadImagesService->upload('news', 'image', $newsService->news->id, true, $request);

            if ($request->hasFile('video'))
                $mediaService->upload('news', 'video', $newsService->news->id, '', true, $request);

            return redirect()->back()->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error.update'));
        }
    }


    public function destroy(News $news)
    {
        abort_if(Gate::denies('news delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        foreach ($news->filesAll as $file) {
            if (!$file->first) {
                $file->delete();
            }
        }
        $news->delete();
        Cache::delete('categories');
        Cache::delete('video_news');
        Cache::delete('fresh_news');
        Cache::delete('top_10_news');
        Cache::delete('main_news');
        return response(['status' => 1]);
    }

    public function dataTable($data,$count)
    {
        return datatables()
            ->of($data)
            ->editColumn('title', function ($row) {
                return Str::limit($row->translations->whereNotNull('title')->first()->title, $limit = 30, $end = '...');
            })
            ->editColumn('actions', function ($row) {
                return $this->permissions($row->id);
            })
            ->rawColumns(['actions'])
            ->skipPaging()
            ->setTotalRecords($count)
            ->setFilteredRecords($count)
            ->make(true);
    }

    public function permissions($id): string
    {
        $class = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('news index')) {
            $result .= "<a href='" . route('backend.news.show', ['news' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('news edit')) {
            $result .= "<a href='" . route('backend.news.edit', ['news' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('news delete')) {
            $result .= "<a href='" . route('backend.news.destroy', ['news' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
