<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private AuthRepositoryInterface $authRepository
    ) {
    }

    public function login(Request $request): array
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken(date('ymdHisT'))->plainTextToken;

            return ['message' => $token, 'status' => 200];
        }

        return ['message' => 'Não autorizado', 'status' => 401];
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
