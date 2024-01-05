<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadMediaService
{
    public function upload($model,$file,$id_model,$collectionName,$multiple, \Illuminate\Http\Request $fileRequest)
    {
        $collectionName = '';
        try {
            DB::beginTransaction();
            $files = $fileRequest->file($file);
            if ($multiple){
                foreach ($files as $file){
                    $document = Storage::disk('media')->put($collectionName, $file);
                    Media::create([
                        'manipulationable_type' => $model,
                        'manipulationable_id' => $id_model,
                        'document' => $document,
                        'collection_name' => $collectionName,
                    ]);
                }
            }else{
                if (isset($files[0])){
                    $document = Storage::disk('media')->put($collectionName, $files[0]);
                    Media::create([
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
