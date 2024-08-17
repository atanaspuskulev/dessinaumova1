<?php

namespace App\Http\Services;

use App\Models\Tag;

class TagService
{
    public function exists(string $name): bool
    {
        return (bool) Tag::where('name', $name)->first();
    }
}
