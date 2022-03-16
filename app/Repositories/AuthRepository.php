<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(Request $request): array
    {
        return User::all()->toArray();
    }
}
