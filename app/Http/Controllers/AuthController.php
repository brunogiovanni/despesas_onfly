<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request): Response
    {
        $result = $this->authService->login($request);

        return response(['message' => $result['message']], $result['status']);
    }

    public function logout(): Response
    {
        $this->authService->logout();

        return response(['message' => 'Deslogado com sucesso'], 200);
    }
}
