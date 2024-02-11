<?php

namespace App\Http\Services;

use App\Http\Services\Interfaces\StorageServiceInterface;

class SessionStorageService implements StorageServiceInterface
{
    public function store(string $key, mixed $value)
    {
        session()->put($key, $value);
    }

    public function get(string $key, mixed $default = null)
    {
        return session()->get($key, $default);
    }

    public function invalidate(string $key)
    {
        session()->forget($key);
    }
}
