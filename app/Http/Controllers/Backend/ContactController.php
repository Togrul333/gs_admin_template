<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contacts index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = ContactRequest::count();
            $data = ContactRequest::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.contacts.index');
    }
    public function show(ContactRequest $contact): View
    {
        abort_if(Gate::denies('contacts index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.contacts.show', compact('contact'));
    }


    public function destroy(ContactRequest $contact)
    {
        abort_if(Gate::denies('contacts delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $contact->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('fullName', function ($row) {
                return  $row->fullName;
            })
            ->editColumn('email', function ($row) {
                return $row->email;
            })
            ->editColumn('subject', function ($row) {
                return $row->subject;
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

        if (admin()->can('contacts index')) {
            $result .= "<a href='" . route('backend.contacts.show', ['contact' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('contacts delete')) {
            $result .= "<a href='" . route('backend.contacts.destroy', ['contact' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
