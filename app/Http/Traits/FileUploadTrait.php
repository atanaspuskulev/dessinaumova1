<?php

namespace App\Http\Traits;

use App\Models\Images;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{
    public function uploadFiles(ValidatesWhenResolved $request, string $keyName, Model $model)
    {
        if ($request->hasFile($keyName)) {
            $files = $request->file($keyName);

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $path = sprintf("uploads/%d", $model->id);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(20);
                    $storageFilename = "{$fileName}.{$extension}";

                    // Store the original image
                    $originalPath = "{$path}/original/{$storageFilename}";
                    $file->storeAs('public', $originalPath);

                    // Generate a thumbnail and store it in the thumbnails directory
                    $thumbnailPath = "{$path}/thumbnails/{$storageFilename}";
                    $this->generateThumbnail($file, $thumbnailPath);

                    $model->gallery()->create(['path' => $storageFilename]);
                }
            }
        }
    }

    protected function generateThumbnail($file, string $thumbnailPath): string
    {
        $image = Image::make($file);
        $image->fit(200, 200); // Adjust the dimensions for your thumbnails
        Storage::disk('public')->put($thumbnailPath, $image->encode());

        return $thumbnailPath;
    }

    public function deleteImage(Model $model, Images $imageObject): void
    {
        $path = sprintf("uploads/%d", $model->id);

        Storage::disk('public')->delete(sprintf("%s/original/%s", $path, $imageObject->path));
        Storage::disk('public')->delete(sprintf("%s/thumbnails/%s", $path, $imageObject->path));
    }
}
