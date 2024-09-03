<?php

namespace App\Http\Traits;

use App\Models\Images;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
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

                    $temp_path = storage_path($path);

                    if (!File::exists($temp_path)) {
                        File::makeDirectory($temp_path, 0777, true);
                    } else {
                        File::chmod($temp_path, 0777);
                    }

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

    protected function generateThumbnail(UploadedFile $file, string $thumbnailPath): string
    {;
        $configThumbnail = config('images.resize.thumbnail');
        $image = Image::make($file);
        $image->fit($configThumbnail['max_width'], $configThumbnail['max_height']); // Adjust the dimensions for your thumbnails
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
