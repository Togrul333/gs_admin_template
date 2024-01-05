<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormSettingRequest;
use App\Interfaces\DatatableInterface;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('settings index'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            return $this->dataTable(Setting::all());
        }

        return view('backend.settings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('settings create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        return view('backend.settings.form', compact('edit'));
    }

    public function store(FormSettingRequest $request)
    {
        abort_if(Gate::denies('settings create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $setting = Setting::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $setting->translations()->create([
                    'locale' => $lang->code,
                    'content' => $data['content:' . $lang->code],
                ]);
            }
            DB::commit();
            return redirect(route('backend.settings.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning('error');
        }
    }

    public function show(Setting $setting)
    {
        abort_if(Gate::denies('settings show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.settings.show', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        abort_if(Gate::denies('settings edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        return view('backend.settings.form', compact('setting', 'edit'));
    }

    public function update(FormSettingRequest $request, Setting $setting)
    {
        abort_if(Gate::denies('settings edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $setting->update([
                'name' => $data['name'],
                'slug' => $data['slug'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $setting->translations()->updateOrcreate(
                    ['locale' => $lang->code],
                    [
                        'locale' => $lang->code,
                        'content' => $data['content:' . $lang->code],
                    ]
                );
            }
            DB::commit();
            return redirect(route('backend.settings.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning('error');
        }
    }

    public function destroy(Setting $setting)
    {
        abort_if(Gate::denies('settings delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $setting->delete();
            return response(['status' => 1]);
        } catch (\Exception $e) {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }

    public function dataTable($data)
    {
        return datatables()
            ->of($data)
            ->addColumn('content', function ($row) {
                return Str::limit($row->translate(default_lang())->content, 30);
            })
            ->addColumn('actions', function ($row) {
                return $this->permissions($row->id);
            })
            ->rawColumns(['content', 'actions'])
            ->make(true);
    }

    public function permissions($id)
    {
        $class = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('settings show')) {
            $result .= "<a href='" . route('backend.settings.show', ['setting' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('settings edit')) {
            $result .= "<a href='" . route('backend.settings.edit', ['setting' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('settings delete')) {
            $result .= "<a href='" . route('backend.settings.destroy', ['setting' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
