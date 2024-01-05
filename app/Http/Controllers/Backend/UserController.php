<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormUserRequest;
use App\Interfaces\DatatableInterface;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('users index'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $limit = request('length');
            $start = request('start');
            $count = User::count();
            $data = User::with('info')->latest()->offset($start)->limit($limit)->get();

            return $this->dataTable($data, $count);
        }

        return view('backend.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('users create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $edit = false;
        return view('backend.users.form', compact('edit'));
    }

    public function store(FormUserRequest $request)
    {

        abort_if(Gate::denies('users create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

      $user = User::create($request->validated());
      $user->info()->create($request->validated());

        return redirect(route('backend.users.index'))->withSuccess(trans('backend.messages.success.create'));
    }

    public function show(User $user)
    {

        abort_if(Gate::denies('users show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('users edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $edit = true;
        return view('backend.users.form', compact('user', 'edit'));
    }

    public function update(FormUserRequest $request, User $user)
    {
        abort_if(Gate::denies('users edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->update($request->validated() + ['password' => !empty($request->password) ?  $request->password : $user->password]);
        $user->info()->update($request->only(['birthdate', 'phone', 'address']));
        return redirect()->route('backend.users.index')->withSuccess(trans('backend.messages.success.update'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('users delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('fullname', function ($row) {
                return $row->fullname;
            })
            ->editColumn('phone', function ($row) {
                return $row->info->phone ?? '-';
            })
            ->editColumn('status', function($row)
            {
                return badge($row->status);
            })
            ->editColumn('actions', function ($row) {
                return $this->permissions($row->id);
            })
            ->rawColumns(['phone','address','status','actions'])
            ->skipPaging()
            ->setTotalRecords($count)
            ->setFilteredRecords($count)
            ->make(true);
    }

    public function permissions($id): string
    {
        $class = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('users show')) {
            $result .= "<a href='" . route('backend.users.show', ['user' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('users edit')) {
            $result .= "<a href='" . route('backend.users.edit', ['user' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('users delete')) {
            $result .= "<a href='" . route('backend.users.destroy', ['user' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
