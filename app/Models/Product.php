<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'material',
        'dimentions1',
        'dimentions2',
        'dimentions3',
        'price',
        'currency',
        'delivery',
        'sold',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'order'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });

        static::creating(function ($item) {
            $item->slug = Str::lower(Str::slug($item->title));
            $item->created_at = now()->toDateString();
        });

        static::updating(function ($item) {
            $item->updated_at = now()->toDateString();
        });
    }

    public function gallery(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable')->orderBy('order', 'asc');
    }

    public function thumbnail(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable')
            ->orderBy('order', 'asc')
            ->take(1);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
