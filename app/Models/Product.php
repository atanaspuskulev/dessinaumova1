<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->slug = Str::lower(Str::slug($item->title));
            $item->created_at = now()->toDateString();
        });

        static::updating(function ($item) {
            $item->updating_at = now()->toDateString();
        });
    }

    public function gallery(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
