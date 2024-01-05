<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormAdminRequest;
use App\Interfaces\DatatableInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('admins index'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        if (request()->ajax())
        {
            return $this->dataTable(Admin::where('role_id', '!=', 2)->get());
        }

        return view('backend.admins.index');
    }

    public function create()
    {
        abort_if(Gate::denies('admins create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $roles = Role::all();
        $edit = false;
        return view('backend.admins.form', compact('roles','edit'));
    }

    public function store(FormAdminRequest $request)
    {
        abort_if(Gate::denies('admins create'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            DB::transaction(function () use ($request)
            {
                $admin = Admin::create($request->validated());
                $admin->assignRole($request->role_id);
            });

            return redirect(route('backend.admins.index'))->withSuccess(trans('backend.messages.success.create'));
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return redirect(route('backend.admins.index'))->withError(trans('backend.messages.error.create'));
        }
    }

    public function edit(Admin $admin)
    {
        abort_if(Gate::denies('admins edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        $roles = Role::all();
        $edit = true;
        return view('backend.admins.form', compact('admin', 'roles','edit'));
    }
    public function update(FormAdminRequest $request, Admin $admin)
    {
        abort_if(Gate::denies('admins edit'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            DB::transaction(function () use ($request, $admin)
            {
                $admin->update($request->except('password'));
                $admin->syncRoles($request->role_id);

                if(!is_null($request->password)) {
                    $admin->update(['password' => $request->password]);
                }
            });

            return redirect(route('backend.admins.index'))->withSuccess(trans('backend.messages.success.update'));
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return redirect(route('backend.admins.index'))->withError(trans('backend.messages.error.update'));
        }
    }

    public function destroy(Admin $admin)
    {
        abort_if(Gate::denies('admins delete'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            DB::transaction(function () use ($admin)
            {
                $admin->delete();
                $admin->roles()->detach();
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
            ->addColumn('role', function($row)
            {
                return $row->role->name;
            })
            ->addColumn('status', function($row)
            {
                return badge($row->status);
            })
            ->addColumn('actions', function($row)
            {
                return $this->permissions($row->id);
            })
            ->rawColumns(['status','actions'])
            ->make(true);
    }

    public function permissions($id): string
    {
        $class  = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('admins edit'))
        {
            $result .= "<a href='" . route('backend.admins.edit', ['admin' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('admins delete'))
        {
            $result .= "<a href='" . route('backend.admins.destroy', ['admin' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
