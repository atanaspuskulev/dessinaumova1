<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'is_active',
        'description',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'position'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });

        static::creating(function ($item) {
            $item->slug = Str::lower(Str::slug($item->title));
            $item->created_at = now()->toDateString();

            if($item->position === null) {
                $item->position = 0;
            }
        });

        static::updating(function ($item) {
            $item->updated_at = now()->toDateString();
        });
    }

    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Images::class, 'imageable');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
