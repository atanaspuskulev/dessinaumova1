<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Painting extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function gallery(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
