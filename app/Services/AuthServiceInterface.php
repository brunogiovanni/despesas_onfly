<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(Request $request): array;
    public function logout(): void;
}
