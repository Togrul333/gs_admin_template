<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormFaqRequest;
use App\Http\Requests\Backend\FormNewsRequest;
use App\Http\Requests\Backend\FormPackageRequest;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Language;
use App\Models\News;
use App\Models\Package;
use App\Services\UploadImagesService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class FaqsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('faqs index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Faq::count();
            $data = Faq::latest()->get();
            return $this->dataTable($data, $count);
        }
        return view('backend.faqs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('faqs create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        $langs = Language::active()->get();
        return view('backend.faqs.form', compact('edit', 'langs'));
    }

    public function store(FormFaqRequest $request)
    {
        abort_if(Gate::denies('faqs create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $faq = Faq::create([
                'status' => $data['status'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $faq->translations()->create([
                    'locale' => $lang->code,
                    'question' => $data['question:' . $lang->code],
                    'answer' => $data['answer:' . $lang->code],
                ]);
            }
            DB::commit();
            return redirect(route('backend.faqs.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }

    public function show(Faq $faq): View
    {
        abort_if(Gate::denies('faqs index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        abort_if(Gate::denies('faqs edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        $langs = Language::active()->get();
        return view('backend.faqs.form', compact('faq', 'edit', 'langs'));
    }

    public function update(FormFaqRequest $request,Faq $faq)
    {
        abort_if(Gate::denies('faqs edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $faq->update([
                'status' => $data['status'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $faq->translations()->updateOrcreate(
                    ['locale' => $lang->code],
                    [
                        'question' => $data['question:' . $lang->code],
                        'answer' => $data['answer:' . $lang->code],
                    ]
                );
            }
            DB::commit();
            return redirect(route('backend.faqs.index'))->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }


    public function destroy(Faq $faq)
    {
        abort_if(Gate::denies('faqs delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $faq->delete();
        return response(['status' => 1]);
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->editColumn('question', function ($row) {
                return  Str::limit($row->translation->question, $limit = 30, $end = '...');
            })
            ->editColumn('answer', function ($row) {
                return Str::limit($row->translation->answer, $limit = 30, $end = '...');
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

        if (admin()->can('faqs index')) {
            $result .= "<a href='" . route('backend.faqs.show', ['faq' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('faqs edit')) {
            $result .= "<a href='" . route('backend.faqs.edit', ['faq' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('faqs delete')) {
            $result .= "<a href='" . route('backend.faqs.destroy', ['faq' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
