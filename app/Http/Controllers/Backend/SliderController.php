<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FormSliderRequest;
use App\Models\Slider;
use App\Services\UploadDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sliders index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $count = Slider::count();
            $data = Slider::get();
            return $this->dataTable($data, $count);
        }
        return view('backend.sliders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sliders create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = false;
        return view('backend.sliders.form', compact('edit'));
    }

    public function store(FormSliderRequest $request,UploadDocumentService $uploadDocumentService)
    {
        abort_if(Gate::denies('sliders create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $slider = Slider::create([
                'type' => $data['type'],
                'order' => $data['order'],
                'link' => $data['link'],
                'status' => $data['status'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $slider->translations()->create([
                    'locale' => $lang->code,
                    'name' => $data['name:' . $lang->code],
                    'text' => $data['text:' . $lang->code],
                ]);
            }
            if ($request->hasFile('image')) {
                $uploadDocumentService->upload('slider', 'image', $slider->id, 'slider_image', false, $request);
            }
            DB::commit();
            return redirect(route('backend.sliders.index'))->withSuccess(trans('backend.messages.success.create'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }


    public function show(Slider $slider)
    {
        abort_if(Gate::denies('sliders index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        abort_if(Gate::denies('sliders edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $edit = true;
        return view('backend.sliders.form', compact('slider', 'edit'));
    }

    public function update(FormSliderRequest $request, Slider $slider, UploadDocumentService $uploadDocumentService)
    {
        abort_if(Gate::denies('sliders edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $slider->update([
                'type' => $data['type'],
                'order' => $data['order'],
                'link' => $data['link'],
                'status' => $data['status'],
            ]);
            foreach (Cache::get('active_langs') as $lang) {
                $slider->translations()->updateOrcreate(
                    ['locale' => $lang->code],
                    [
                        'name' => $data['name:' . $lang->code],
                        'text' => $data['text:' . $lang->code],
                    ]
                );
            }
            if ($request->hasFile('image')) {
                if ($slider->files->where('collection_name','slider_image')->first()) {
                    return redirect()->back()->withWarning(trans('backend.messages.error.removeOldImage'));
                } else {
                    $uploadDocumentService->upload('slider', 'image', $slider->id, 'slider_image', false, $request);
                }
            }
            DB::commit();
            return redirect(route('backend.sliders.index'))->withSuccess(trans('backend.messages.success.update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return redirect()->back()->withWarning(trans('backend.messages.error'));
        }
    }

    public function destroy(Slider $slider)
    {
        abort_if(Gate::denies('sliders delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            foreach ($slider->getDocuments('slider_image') as $file) {
                Storage::disk('documents')->delete($file->getAttributes()['document']);
                $file->delete();
            }
            $slider->delete();
            return response(['status' => 1]);
        } catch (\Exception $e) {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }

    public function dataTable($data, $count)
    {
        return datatables()
            ->of($data)
            ->addColumn('image', function ($row) {
                $src = $row->first_image ? $row->first_image : asset('backend/img/noimage.jpg');
                return '<img src="' . $src . '" alt="' . $row->id . '" style="width:26px; object-fit: contain;">';
            })
            ->addColumn('link', function ($row) {
                return $row->link;
            })
            ->addColumn('tipi', function ($row) {
                return $row->type;
            })
            ->addColumn('status', function ($row) {
                return badge($row->status);
            })
            ->addColumn('actions', function ($row) {
                return $this->permissions($row->id);
            })
            ->rawColumns(['image', 'status', 'actions'])
            ->skipPaging()
            ->setTotalRecords($count)
            ->setFilteredRecords($count)
            ->make(true);
    }

    protected function permissions($id)
    {
        $class = 'btn btn-sm btn-icon btn-clean';
        $result = '';

        if (admin()->can('sliders index')) {
            $result .= "<a href='" . route('backend.sliders.show', ['slider' => $id]) . "'";
            $result .= " class='$class'><i class='la la-eye'></i></a>";
        }

        if (admin()->can('sliders edit')) {
            $result .= "<a href='" . route('backend.sliders.edit', ['slider' => $id]) . "'";
            $result .= " class='$class'><i class='la la-edit'></i></a>";
        }

        if (admin()->can('sliders delete')) {
            $result .= "<a href='" . route('backend.sliders.destroy', ['slider' => $id]) . "'";
            $result .= " class='$class btn-delete'><i class='la la-trash'></i></a>";
        }

        return $result;
    }
}
