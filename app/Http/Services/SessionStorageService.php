<?php

namespace App\Http\Services;


use App\Http\Services\Payment\Interface\StorageInterface;

class SessionStorageService implements StorageInterface
{
    public function store(string $key, mixed $value): void
    {
        session()->put($key, $value);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return session()->get($key, $default);
    }

    public function invalidate(array|string $key): void
    {
        session()->forget($key);
    }

    public function check($key): bool
    {
        return session()->has($key);
    }
}
