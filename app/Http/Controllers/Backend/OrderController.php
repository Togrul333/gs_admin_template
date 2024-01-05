<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Donation;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('orders index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Order::count();
            $data = Order::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.orders.index');
    }
    public function show(Order $order): View
    {
        abort_if(Gate::denies('orders index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.orders.show', compact('order'));
    }


    public function destroy(Order $order)
    {
        abort_if(Gate::denies('orders delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $order->delete();
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

        if (admin()->can('orders index')) {
            $result .= "<a href='" . route('backend.orders.show', ['order' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

//        if (admin()->can('donations delete')) {
//            $result .= "<a href='" . route('backend.donations.destroy', ['donation' => $id]) . "'";
//            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
//        }

        return $result;
    }
}
