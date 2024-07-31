<?php

namespace App\Http\Contracts;

interface CleanupContractInterface
{
    public function cleanupForSession(): void;
}
