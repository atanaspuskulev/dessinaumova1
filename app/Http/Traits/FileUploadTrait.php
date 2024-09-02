<?php

namespace App\Http\Traits;

use App\Models\Images;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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
                    if (!mkdir("{$path}/original", 0777, true) && !is_dir("{$path}/original")) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', "{$path}/original"));
                    }

                    $file->storeAs('public', $originalPath);

                    // Generate a thumbnail and store it in the thumbnails directory
                    $thumbnailPath = "{$path}/thumbnails/{$storageFilename}";
                    if (!mkdir("{$path}/thumbnails", 0777, true) && !is_dir("{$path}/thumbnails")) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', "{$path}/thumbnails"));
                    }
                    $this->generateThumbnail($file, $thumbnailPath);
                    $model->gallery()->create(['path' => $storageFilename]);
                }
            }
        }
    }

    protected function generateThumbnail(UploadedFile $file, string $thumbnailPath): string
    {
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
