<?php

namespace App\Http\Services\Payment\Interface;

interface StorageInterface
{
    public function store(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

    public function invalidate(string $key): void;

    public function check($key): bool;
}
