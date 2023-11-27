<?php

declare(strict_types=1);

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

    if ($fileExists) {
        return asset("storage/{$storageDirectory}/{$path}");
    }
    return $defaultImage;
}

function admin_link_active_class(
    string $matchAgainst,
    string $defaultClass = 'nav-item',
    $addClass = 'active',
    string $defaultHome = 'admin'
): string
{
    if (request()->path() !== $defaultHome && preg_match($matchAgainst, request()->path())) {
        return $defaultClass . ' ' . $addClass;
    }
    return $defaultClass;
}

