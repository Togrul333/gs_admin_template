<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormWritingRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\Language;
use App\Models\Option;
use App\Models\Writer;
use App\Models\Writing;
use App\Services\UploadImagesService;
use App\Services\UploadMediaService;
use App\Services\WritingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class WritingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('writings index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Writing::count();
            $data = Writing::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.writings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('writings create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        $langs = Language::active()->get();
        $categories = Category::get();
        $options = Option::get();
        $writers = Writer::get();

        $files = Document::whereNull('parent_id')->unique()->paginate(12)->withQueryString();

        return view('backend.writings.form', compact('edit', 'langs','writers',
            'categories', 'options', 'files'));
    }

    public function store(FormWritingRequest $request, WritingService $writingService, UploadImagesService $uploadImagesService,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('writings create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $writingService->create($request->validated());

            if ($request->has('selectedFiles'))
                $uploadImagesService->attachImages('writing', $writingService->writing->id, $request->get('selectedFiles'));

            if ($request->hasFile('image'))
                $uploadImagesService->upload('writing', 'image', $writingService->writing->id, true, $request);

            if ($request->hasFile('video'))
                $mediaService->upload('writing', 'video', $writingService->writing->id, '', true, $request);

            return redirect(route('backend.writings.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error.create'));
        }
    }

    public function show(Writing $writing): View
    {
        abort_if(Gate::denies('writings index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.writings.show', compact('writing'));
    }

    public function edit(Writing $writing)
    {
        abort_if(Gate::denies('writings edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        $langs = Language::active()->get();
        $categories = Category::get();
        $options = Option::get();
        $writers = Writer::get();

        $files = Document::whereNull('parent_id')->unique()->paginate(12)->withQueryString();

        return view('backend.writings.form', compact('writing','writing','writers',
            'edit', 'langs', 'categories', 'options', 'files'));
    }

    public function update(FormWritingRequest $request, Writing $writing, WritingService $writingService, UploadImagesService $uploadImagesService,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('writings edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        dd($request->validated());
        try {
            $data = $request->validated();
            $data['writing'] = $writing;
            $writingService->update($data);

            if ($request->has('selectedFiles'))
                $uploadImagesService->attachImages('writing', $writingService->writing->id, $request->get('selectedFiles'));

            if ($request->hasFile('image'))
                $uploadImagesService->upload('writing', 'image', $writingService->writing->id, true, $request);

            if ($request->hasFile('video'))
                $mediaService->upload('writing', 'video', $writingService->writing->id, '', true, $request);

            return redirect()->back()->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error.update'));
        }
    }


    public function destroy(Writing $writing)
    {
        abort_if(Gate::denies('writings delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        foreach ($writing->filesAll as $file) {
            if (!$file->first) {
                $file->delete();
            }
        }
        $writing->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('title', function ($row) {
                return Str::limit($row->translation->title, $limit = 30, $end = '...');
            })
//            ->editColumn('content', function ($row) {
//                return Str::limit(strip_tags($row->translation->content), $limit = 30, $end = '...');
//            })
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

        if (admin()->can('writings index')) {
            $result .= "<a href='" . route('backend.writings.show', ['writing' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('writings edit')) {
            $result .= "<a href='" . route('backend.writings.edit', ['writing' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('writings delete')) {
            $result .= "<a href='" . route('backend.writings.destroy', ['writing' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
