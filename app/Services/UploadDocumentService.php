<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadDocumentService
{
    public function upload($model,$file,$id_model,$collectionName,$multiple, \Illuminate\Http\Request $fileRequest)
    {
        try {
            DB::beginTransaction();
            $files = $fileRequest->file($file);
            if ($multiple){
                foreach ($files as $file){
                    $document = Storage::disk('documents')->put($collectionName, $file);
                    Document::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'collection_name' => $collectionName,
                    ]);
                }
            }else{
                if (isset($files[0])){
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

//    public function update($model_name,$model,$multiple, \Illuminate\Http\Request $fileRequest)
//    {
//        try {
//            DB::beginTransaction();
//            $files = $fileRequest->file('image');
//            if ($multiple){
//                foreach ($files as $file){
//                    $document = Storage::disk('documents')->put('', $file);
//                    $document_exist = $model->files()->first();
//                    if ($document_exist) {
//                        Storage::disk('documents')->delete($document_exist->getAttributes()['document']);
//                    }
//                    Document::updateOrCreate([
//                        'manipulationable_type' => $model_name,
//                        'manipulationable_id' => $model->id,
//                    ], [
//                        'manipulationable_type' => $model_name,
//                        'manipulationable_id' => $model->id,
//                        'document' => $document,
//                    ]);
//                }
//            }else{
//                if (isset($files[0])){
//                    $document = Storage::disk('documents')->put('', $files[0]);
//                    $document_exist = $model->files()->first();
//                    if ($document_exist) {
//                        Storage::disk('documents')->delete($document_exist->getAttributes()['document']);
//                    }
//                    Document::updateOrCreate([
//                        'manipulationable_type' => $model_name,
//                        'manipulationable_id' => $model->id,
//                    ], [
//                        'manipulationable_type' => $model_name,
//                        'manipulationable_id' => $model->id,
//                        'document' => $document,
//                    ]);
//                }
//            }
//            return true;
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            throw new \Exception($exception->getMessage());
//        }
//    }
}
