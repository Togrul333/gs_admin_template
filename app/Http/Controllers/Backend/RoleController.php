<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormRoleRequest;
use App\Interfaces\DatatableInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('roles index'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        if (request()->ajax())
        {
            return $this->dataTable(Role::all());
        }

        return view('backend.roles.index');
    }

    public function create()
    {
        abort_if(Gate::denies('roles create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $permissions = Permission::all();
        $edit = false;
        return view('backend.roles.form', compact('permissions','edit'));
    }

    public function store(FormRoleRequest $request)
    {
        abort_if(Gate::denies('roles create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            DB::transaction(function () use ($request)
            {
                $role = Role::create($request->only('name'));
                $role->givePermissionTo($request->permissions);
            });

            return redirect(route('backend.roles.index'))->withSuccess(trans('backend.messages.success.create'));
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return redirect(route('backend.roles.index'))->withError(trans('backend.messages.error.create'));
        }
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('roles show'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        return view('backend.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('roles edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

            $permissions     = Permission::all();
            $rolePermissions = $role->permissions()->pluck('permission_id')->toArray();
            $edit=true;

            return view('backend.roles.form', compact('role', 'permissions', 'rolePermissions','edit'));
    }

    public function update(FormRoleRequest $request, Role $role)
    {
        abort_if(Gate::denies('roles edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            DB::transaction(function () use ($request, $role)
            {
                $role->update($request->only('name'));
                $role->syncPermissions($request->permissions);
            });

            return redirect(route('backend.roles.index'))->withSuccess(trans('backend.messages.success.update'));
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return redirect(route('backend.roles.index'))->withError(trans('backend.messages.error.update'));
        }
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('roles destroy'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            $roleHasAdmin = Admin::whereRoleId($role->id)->count();

            if ($roleHasAdmin)
            {
                return response(['status' => 2]);
            }

            $permissions = $role->permissions()->pluck('permission_id')->toArray();

            DB::transaction(function () use ($role, $permissions)
            {
                $role->delete();
                $role->revokePermissionTo($permissions);
            });

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
            ->addColumn('actions', function($row)
            {
                return $this->permissions($row->id);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function permissions($id): string
    {
        $class  = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('roles show'))
        {
            $result .= "<a href='" . route('backend.roles.show', ['role' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('roles edit'))
        {
            $result .= "<a href='" . route('backend.roles.edit', ['role' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('roles delete'))
        {
            $result .= "<a href='" . route('backend.roles.destroy', ['role' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
