<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Donation;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class DonationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('donations index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Donation::count();
            $data = Donation::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.donations.index');
    }
    public function show(Donation $donation): View
    {
        abort_if(Gate::denies('donations index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.donations.show', compact('donation'));
    }


    public function destroy(Donation $donation)
    {
        abort_if(Gate::denies('donations delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $donation->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('ip_address', function ($row) {
                return  $row->ip_address;
            })
            ->editColumn('total_amount', function ($row) {
                return $row->total_amount;
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

        if (admin()->can('donations index')) {
            $result .= "<a href='" . route('backend.donations.show', ['donation' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

//        if (admin()->can('donations delete')) {
//            $result .= "<a href='" . route('backend.donations.destroy', ['donation' => $id]) . "'";
//            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
//        }

        return $result;
    }
}
