<?php

use Illuminate\Support\Facades\Storage;

function displayImage(int $recordId, string $path, bool $isThumbnail = false, string $thumbnailPath = 'thumbnails'): string
{
    $storageDirectory = "uploads/{$recordId}/" . ($isThumbnail ? $thumbnailPath : 'original');
    $fileExists = Storage::disk('public')->exists($storageDirectory . '/' . $path);

    return $fileExists
        ? asset("storage/{$storageDirectory}/{$path}")
        : asset('assets/images/default-image.png');
}
