<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UploadImagesService
{
    public function upload($model, $file, $id_model, $multiple, \Illuminate\Http\Request $request)
    {
        $collectionName = '';
        try {
            DB::beginTransaction();
            $files = $request->file($file);

            if ($multiple) {
                foreach ($files as $file) {
                    $getClientOriginalName = $file->getClientOriginalName();
                    $document = Storage::disk('documents')->put($collectionName, $file);
                    $status = null;
                    $alt = null;
                    if (request()->has('selectMain')) {
                        if ($getClientOriginalName == request()->get('selectMain')) {
                            $status = 'main';
                        }
                    }
                    if (request()->has('alt_uploaded')) {
                        $arr = request()->get('alt_uploaded');
                        $alt = $arr[$getClientOriginalName];
                    }
                    $doc = Document::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'status' => $status,
                        'alt' => $alt,
                        'collection_name' => $collectionName,
                    ]);
//                    $this->createResizedImages($collectionName, $document, $doc, $model, $id_model);
                }
            } else {
                if (isset($files[0])) {
                    $getClientOriginalName = $files[0]->getClientOriginalName();
                    $document = Storage::disk('documents')->put($collectionName, $files[0]);
                    $status = null;
                    $alt = null;
                    if (request()->has('selectMain_uploaded')) {
                        if ($getClientOriginalName == request()->get('selectMain_uploaded')) {
                            $status = 'main';
                        }
                    }
                    if (request()->has('alt_uploaded')) {
                        $arr = request()->get('alt_uploaded');
                        $alt = isset($arr[$getClientOriginalName]) ? $arr[$getClientOriginalName] : null;
                    }
                    $doc = Document::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'status' => $status,
                        'alt' => $alt,
                        'collection_name' => $collectionName,
                    ]);
//                    $this->createResizedImages($collectionName, $document, $doc, $model, $id_model);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    protected function createResizedImages($collectionName, $document, $doc, $model, $id_model)
    {
        $originalImagePath = Storage::disk('documents')->path($document);
        $image = Image::make($originalImagePath);

        $smallImagePath = Storage::disk('documents')->path($document . '_small.jpg');
        $mediumImagePath = Storage::disk('documents')->path($document . '_medium.jpg');
        $largeImagePath = Storage::disk('documents')->path($document . '_large.jpg');

        $this->documentCreate($model, $id_model, $document . '_small.jpg', $collectionName, $doc);
        $this->documentCreate($model, $id_model, $document . '_medium.jpg', $collectionName, $doc);
        $this->documentCreate($model, $id_model, $document . '_large.jpg', $collectionName, $doc);

        $image->fit(64, 64)->save($smallImagePath);
        $image->fit(348, 248)->save($mediumImagePath);
        $image->fit(872, 432)->save($largeImagePath);
    }

    public function documentCreate($model, $id_model, $document, $collectionName, $doc)
    {
        return Document::create([
            'manipulationable_type' => $model,
            'manipulationable_id' => $id_model,
            'document' => $document,
            'parent_id' => $doc->id,
            'collection_name' => $collectionName,
        ]);
    }

    public function attachImages($model, $id_model, $document_ids)
    {
        foreach ($document_ids as $document_id) {
            $file = Document::find($document_id);
            $doc = $file->getAttributes()['document'];

            $status = null;
            $alt = null;
            if (request()->has('selectMain')) {
                if ($doc == basename(request()->get('selectMain'))) {
                    $status = 'main';
                }
            }
            if (request()->has('alt_selected')) {
                $alts = request()->get('alt_selected');
                $urls = array_keys(request()->get('alt_selected'));
                foreach ($urls as $url) {
                    $path = parse_url($url, PHP_URL_PATH);
                    $filename = pathinfo($path, PATHINFO_BASENAME);
                    if ($filename ==  $doc && isset($alts[$url])) {
                        $alt = $alts[$url];
                    }
                }
            }

            Document::create([
                'manipulationable_type' => $model,
                'manipulationable_id' => $id_model,
                'document' => $doc,
                'status' => $status,
                'alt' => $alt,
                'first' => '0',
                'collection_name' => '',
            ]);
        }
        return true;
    }


    public function uploadAdmin($model, $file, $id_model, $multiple, \Illuminate\Http\Request $request)
    {
        $collectionName = '';
        try {
            DB::beginTransaction();
            $files = $request->file($file);

            if ($multiple) {
                foreach ($files as $file) {
                    $document = Storage::disk('documents')->put($collectionName, $file);
                    Document::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'collection_name' => $collectionName,
                    ]);
                }
            } else {
                if (isset($files[0])) {
                    $document = Storage::disk('documents')->put($collectionName, $files[0]);
                     Document::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'collection_name' => $collectionName,
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

}
