<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\UploadImagesService;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = Document::latest()->whereNull('parent_id')->unique()->paginate(12)->withQueryString();
//        if (request()->ajax()) {
//            $view = view('backend.file-manager.index', compact('files'))->render();
//            return response()->json(['view' => $view]);
//        }
        return view('backend.file-manager.index', compact('files'));
    }

    public function upload(Request $request,UploadImagesService $uploadImagesService)
    {
        if ($request->hasFile('image'))
            $uploadImagesService->uploadAdmin('admin', 'image', 1, true, $request);

        return redirect()->back()->withSuccess(trans('backend.messages.success.create'));
    }
}
