<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function deleteDocument(Document $document)
    {
        try {
            if ($document) {
                Storage::disk('documents')->delete($document->getAttributes()['document']);
            }
            // bu weklin resize edilen diger versiyalarin silmek ucun
            if ($document->documents->count()) {
                foreach ($document->documents as $doc) {
                    Storage::disk('documents')->delete($doc->getAttributes()['document']);
                }
            }

            // copyalanmis diger eyni sekiller bazadan silmek ucun
            $query = Document::where('document', $document->getAttributes()['document']);
            $query->delete();

            $document->delete();
            return response(['status' => 1]);
        } catch (\Exception $e) {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }
    public function setStatus(Document $document)
    {
        try {
            $query = Document::whereNull('parent_id')
                ->where('manipulationable_type', $document->manipulationable_type)
                ->where('manipulationable_id', $document->manipulationable_id);

            $query->update(['status' => null]);

            $document->status = 'main';
            $document->save();
            return response(['status' => 1]);
        } catch (\Exception $e) {
            Log::channel('backend')->error($e->getMessage());
            return response(['status' => 0]);
        }
    }
}
