<?php

declare(strict_types=1);

namespace App\Models;

use App\Jobs\GenerateSitemapJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
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
        'shipping_cost',
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
            if($item->shipping_cost === null) {
                $item->shipping_cost = 0;
            }
            $item->slug = Str::lower(Str::slug($item->title));
            $item->created_at = now()->toDateString();
        });

        static::updating(function ($item) {
            if($item->shipping_cost === null) {
                $item->shipping_cost = 0;
            }
            $item->updated_at = now()->toDateString();
        });

        static::created(function ($product) {
            // Dispatch the job when a product is created
            GenerateSitemapJob::dispatch();
        });

        static::updated(function ($product) {
            // Dispatch the job when a product is updated
            GenerateSitemapJob::dispatch();
        });
    }

    public function gallery(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable')
            ->orderBy('order', 'asc');
    }

    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Images::class, 'imageable')
            ->orderBy('order', 'asc');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
