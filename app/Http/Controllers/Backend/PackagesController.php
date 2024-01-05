<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormNewsRequest;
use App\Http\Requests\Backend\FormPackageRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Package;
use App\Services\UploadImagesService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PackagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('packages index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Package::count();
            $data = Package::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.packages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('packages create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        $langs = Language::active()->get();
        $categories = Category::get();
        return view('backend.packages.form', compact('edit', 'langs','categories'));
    }

    public function store(FormPackageRequest $request)
    {
        abort_if(Gate::denies('packages create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $news = Package::create([
                'price' => $data['price'],
                'time' => $data['time'],
                'order' => $data['order'],
                'status' => $data['status'],

            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $news->translations()->create([
                    'locale' => $lang->code,
                    'type' => $data['type:' . $lang->code],
                    'condition' => $data['condition:' . $lang->code],
                    'description' => $data['description:' . $lang->code],
                ]);
            }
            DB::commit();
            return redirect(route('backend.packages.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }

    public function show(Package $package): View
    {
        abort_if(Gate::denies('packages index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        abort_if(Gate::denies('packages edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        $langs = Language::active()->get();
        return view('backend.packages.form', compact('package', 'edit', 'langs'));
    }

    public function update(FormPackageRequest $request,Package $package)
    {
        abort_if(Gate::denies('packages edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $package->update([
                'time' => $data['time'],
                'price' => $data['price'],
                'order' => $data['order'],
                'status' => $data['status'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $package->translations()->updateOrcreate(
                    ['locale' => $lang->code],
                    [
                        'type' => $data['type:' . $lang->code],
                        'condition' => $data['condition:' . $lang->code],
                        'description' => $data['description:' . $lang->code],
                    ]
                );
            }
            DB::commit();
            return redirect(route('backend.packages.index'))->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }


    public function destroy(Package $package)
    {
        abort_if(Gate::denies('packages delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $package->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('type', function ($row) {
                return  Str::limit($row->translation->type, $limit = 30, $end = '...');
            })
            ->editColumn('condition', function ($row) {
                return Str::limit($row->translation->condition, $limit = 30, $end = '...');
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

        if (admin()->can('packages index')) {
            $result .= "<a href='" . route('backend.packages.show', ['package' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('packages edit')) {
            $result .= "<a href='" . route('backend.packages.edit', ['package' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('packages delete')) {
            $result .= "<a href='" . route('backend.packages.destroy', ['package' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
