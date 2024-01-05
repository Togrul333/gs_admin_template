<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('languages index'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax())
        {
            return $this->dataTable(Language::all());
        }

        return view('backend.languages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('languages create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $edit = false;
        return view('backend.languages.form', compact('edit'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('languages create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Language::create($request->all());

        return redirect(route('backend.languages.index'))->withSuccess(trans('backend.messages.success.create'));
    }

    public function edit(Language $language)
    {
        abort_if(Gate::denies('languages edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $edit=true;
        return view('backend.languages.form', compact('language','edit'));
    }

    public function update(Request $request, Language $language)
    {
        abort_if(Gate::denies('languages edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $language->update($request->all());

        return redirect(route('backend.languages.index'))->withSuccess(trans('backend.messages.success.update'));
    }

    public function destroy(Language $language)
    {
        abort_if(Gate::denies('languages delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try
        {
            if ($language->default)
            {
                return response(['status' => 2]);
            }

            $language->delete();
            return response(['status' => 1]);
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }

    public function dataTable($data)
    {
        return datatables()
            ->of($data)
            ->addColumn('default', function($row)
            {
                return badge($row->default);
            })
            ->addColumn('status', function($row)
            {
                return badge($row->status);
            })
            ->addColumn('actions', function($row)
            {
                return $this->permissions($row->id);
            })
            ->rawColumns(['default', 'status', 'actions'])
            ->make(true);
    }

    public function permissions($id)
    {
        $class  = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('languages edit'))
        {
            $result .= "<a href='" . route('backend.languages.edit', ['language' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('languages delete'))
        {
            $result .= "<a href='" . route('backend.languages.destroy', ['language' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
