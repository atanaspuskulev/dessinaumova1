<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($item) {
            $item->slug = Str::lower(Str::slug($item->name));
        });

        static::updating(static function ($item) {
            $item->slug = Str::lower(Str::slug($item->name));
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
