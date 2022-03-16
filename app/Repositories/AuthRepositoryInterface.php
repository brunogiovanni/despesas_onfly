<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function login(Request $request): array;
}
