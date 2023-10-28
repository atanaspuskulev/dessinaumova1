<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'is_active'
    ];

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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
