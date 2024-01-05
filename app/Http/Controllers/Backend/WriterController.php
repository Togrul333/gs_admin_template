<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormCategoryRequest;
use App\Http\Requests\Backend\FormWriterRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\Writer;
use App\Services\UploadMediaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class WriterController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('writers index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Writer::count();
            $data = Writer::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.writers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('writers create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        $langs = Language::active()->get();
        return view('backend.writers.form', compact('edit', 'langs'));
    }

    public function store(FormWriterRequest $request,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('writers create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $writer = Writer::create([
                'name' => $data['name'],
                'slug' =>Str::slug($data['name']),
                'role' => $data['role'],
            ]);
            if ($request->hasFile('image'))
                $mediaService->upload('writer', 'image', $writer->id, '', false, $request);

            DB::commit();
            return redirect(route('backend.writers.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }

    public function show(Writer $writer): View
    {
        abort_if(Gate::denies('writers index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.writers.show', compact('writer'));
    }

    public function edit(Writer $writer)
    {
        abort_if(Gate::denies('writers edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        $langs = Language::active()->get();
        return view('backend.writers.form', compact('writer', 'edit', 'langs'));
    }

    public function update(FormWriterRequest $request, Writer $writer,UploadMediaService  $mediaService)
    {
        abort_if(Gate::denies('writers edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $writer->update([
                'name' => $data['name'],
                'role' => $data['role'],
                'slug' =>Str::slug($data['name']),
            ]);

            if ($request->hasFile('image'))
                $mediaService->upload('writer', 'image', $writer->id, '', false, $request);

            DB::commit();
            return redirect(route('backend.writers.index'))->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }


    public function destroy(Writer $writer)
    {
        abort_if(Gate::denies('categories delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $writer->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('role', function ($row) {
                return $row->role;
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

        if (admin()->can('writers index')) {
            $result .= "<a href='" . route('backend.writers.show', ['writer' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('writers edit')) {
            $result .= "<a href='" . route('backend.writers.edit', ['writer' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('categories delete')) {
            $result .= "<a href='" . route('backend.writers.destroy', ['writer' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
