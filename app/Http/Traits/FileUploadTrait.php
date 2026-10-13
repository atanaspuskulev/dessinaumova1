<?php

namespace App\Http\Traits;

use App\Models\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{
    public function uploadFiles(
        Request $request,
        string $keyName,
        Model $model,
        string $uploadPath = 'uploads',
        string $modelMethodName = 'gallery'
    )
    {
        if ($request->hasFile($keyName)) {
            $files = $request->file($keyName);

            if(!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $path = sprintf("%s/%d", $uploadPath, $model->getKey());

                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(20);
                    $storageFilename = "{$fileName}.{$extension}";

                    // Store the original image
                    $originalPath = "{$path}/original/{$storageFilename}";
                    $file->storeAs('public', $originalPath);

                    // Generate a thumbnail and store it in the thumbnails directory
                    $thumbnailPath = "{$path}/thumbnails/{$storageFilename}";

                    $this->generateThumbnail($file, $thumbnailPath);
                    $model->$modelMethodName()->create(['path' => $storageFilename]);
                }
            }
        }
    }

    protected function generateThumbnail(UploadedFile $file, string $thumbnailPath): string
    {
        $configThumbnail = config('images.resize.thumbnail');
        $image = Image::make($file);
        $image->fit($configThumbnail['max_width'], $configThumbnail['max_height']); // Adjust the dimensions for your thumbnails
        Storage::disk('public')->put($thumbnailPath, (string) $image->encode());

        return $thumbnailPath;
    }

    public function deleteImage(Model $model, Images $imageObject, $uploadPath = 'uploads'): void
    {
        $path = sprintf("%s/%d", $uploadPath, $model->getKey());

        Storage::disk('public')->delete(sprintf("%s/original/%s", $path, $imageObject->path));
        Storage::disk('public')->delete(sprintf("%s/thumbnails/%s", $path, $imageObject->path));
    }
}
