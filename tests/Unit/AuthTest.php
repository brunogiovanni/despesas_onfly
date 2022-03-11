<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware, DatabaseMigrations;

    /**
     * Teste de listagem
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'teste1234')
        ]);
        $loginData = [
            'email' => $user->getAttribute('email'),
            'password' => $password,
        ];
        $response = $this->postJson('/api/login', $loginData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }
}
