<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

trait FileUploadTrait
{
    public function uploadFiles(Request $request, string $keyName, Model $model)
    {
        if($request->hasFile($keyName)) {
            $files = $request->file($keyName);

            foreach ($files as $file) {
                if($file->isValid()) {
                    $file->store(sprintf("uploads/%d", $model->id), 'public');
                }
            }
        }
    }
}
