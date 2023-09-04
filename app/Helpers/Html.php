<?php

use Illuminate\Support\Facades\Storage;

function displayImage(int $recordId, string|null $path, bool|null $isThumbnail = null, string $thumbnailPath = 'thumbnails'): string
{
    $isThumbnail ??= false;
    $defaultImage = asset('assets/images/default-image.png');

    if(!$path) {
        return $defaultImage;
    }

    $storageDirectory = "uploads/{$recordId}/" . ($isThumbnail ? $thumbnailPath : 'original');
    $fileExists = Storage::disk('public')->exists($storageDirectory . '/' . $path);

    return $fileExists
        ? asset("storage/{$storageDirectory}/{$path}")
        : $defaultImage;
}
