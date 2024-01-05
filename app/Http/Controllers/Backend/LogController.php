<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('logs index'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax())
        {
            $limit = request('length');
            $start = request('start');
            $data = Log::latest()->offset($start)->limit($limit)->get();
            $total_filtered = Log::count();

            return $this->dataTable($data, $total_filtered);
        }

        return view('backend.logs.index');
    }

    public function destroy(Activity $log)
    {
        abort_if(Gate::denies('logs delete'), Response::HTTP_FORBIDDEN,'403 Forbidden');

        try
        {
            $log->delete();

            return response(['status' => 1]);
        }

        catch (\Exception $e)
        {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }

    protected function dataTable($data, $total_filtered)
    {
        return datatables()
            ->of($data)
            ->editColumn('id', function (Activity $model) {
                return $model->id;
            })
            ->editColumn('subject_id', function (Activity $model) {
                $return = null;

                if (!isset($model->subject)) {
                    $return = '';
                }

                if (isset($model->subject->name)) {
                    $return = optional($model->subject)->name;
                }

                if (isset($model->subject->user)) {
                    $return = $model->subject->user->first()->name;
                }
                return $return;
            })
            ->editColumn('causer_id', function (Activity $model) {
                return $model->causer ? $model->causer->name : __('System');
            })
            ->editColumn('properties', function (Activity $model) {
                $content = $model->properties;

                return view('backend.logs._details', compact('content'));
            })
            ->editColumn('created_at', function (Activity $model) {
                return $model->created_at->format('d M, Y H:i:s');
            })
            ->addColumn('actions', function($row)
            {
                return $this->permissions($row->id);
            })
            ->skipPaging()
            ->setTotalRecords($total_filtered)
            ->setFilteredRecords($total_filtered)
            ->rawColumns(['description', 'properties', 'actions'])
            ->make(true);
    }

    public function permissions($id): string
    {
        $class  = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('logs delete'))
        {
            $result .= "<a href='" . route('backend.logs.destroy', ['log' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
