<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

function displayImage(
    int $recordId,
    string|null $imageName,
    bool|null $isThumbnail = null,
    string $thumbnailPath = 'thumbnails',
    string $uploadPath = 'uploads'
): string
{
    $isThumbnail ??= false;
    $defaultImage = asset('assets/images/default-image.png');

    if(!$imageName) {
        return $defaultImage;
    }

    $image = sprintf(
        '%s/%s/%s/%s',
        $uploadPath, $recordId, $isThumbnail ? $thumbnailPath : 'original', $imageName
    );

    $fileExists = Storage::disk('public')->exists($image);

    if ($fileExists) {
        return Storage::disk('public')->url($image);
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
    if (
        request()->path() !== $defaultHome &&
        preg_match($matchAgainst, request()->path())
    ) {
        return $defaultClass . ' ' . $addClass;
    }
    return $defaultClass;
}
