<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormPermissionRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permissions index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax())
        {
            return $this->dataTable(Permission::latest()->get());
        }

        return view('backend.permissions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('permissions create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $edit = false;
        return view('backend.permissions.form', compact('edit'));
    }

    public function store(FormPermissionRequest $request)
    {
        abort_if(Gate::denies('permissions create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        Permission::create($request->validated());

        return redirect(route('backend.permissions.index'))->withSuccess(trans('backend.messages.success.create'));
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permissions show'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        return view('backend.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permissions edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $edit=true;

        return view('backend.permissions.form', compact('permission','edit'));
    }

    public function update(FormPermissionRequest $request, Permission $permission)
    {
        abort_if(Gate::denies('permissions edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $permission->update($request->validated());

        return redirect(route('backend.permissions.index'))->withSuccess(trans('backend.messages.success.update'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permissions delete'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            $permission->delete();

            return response(['status' => 1]);
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }

    protected function dataTable($data)
    {
        return datatables()
            ->of($data)
            ->addColumn('actions', function($row)
            {
                return $this->permissions($row->id);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    protected function permissions($id): string
    {
        $class  = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('permissions show'))
        {
            $result .= "<a href='" . route('backend.permissions.show', ['permission' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('permissions edit'))
        {
            $result .= "<a href='" . route('backend.permissions.edit', ['permission' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('permissions delete'))
        {
            $result .= "<a href='" . route('backend.permissions.destroy', ['permission' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
