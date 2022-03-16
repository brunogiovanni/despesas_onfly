<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware, DatabaseMigrations;

    /**
     * Teste de listagem
     *
     * @return void
     */
    public function testIndex()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        User::factory()->count(5)->create()->toArray();

        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "created_at",
                    "updated_at",
                ],
            ]);
    }

    /**
     * Teste de validação de campos
     *
     * @return void
     */
    public function testValidation()
    {
        // Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->postJson('/api/register', []);

        $response
            ->assertStatus(400)
            ->assertJsonFragment(['name' => ["Informe o nome do usuário"]]);
    }

    /**
     * Teste de armazenamento
     *
     * @return void
     */
    public function testStore()
    {
        $fakeUser = User::factory()->make()->makeVisible('password')->toArray();
        $response = $this->postJson('/api/register', $fakeUser);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Sucesso',
            ]);
    }

    /**
     * Teste de update
     *
     * @return void
     */
    public function testUpdate()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeUser = User::factory()->create()->makeVisible('password');
        $response = $this->putJson('/api/user/' . $fakeUser->id, [...$fakeUser->toArray(), 'name' => 'Teste update']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Sucesso',
            ]);
    }

    /**
     * Teste de destroy
     *
     * @return void
     */
    public function testDestroy()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeUser = User::factory()->create()->makeVisible('password');
        $response = $this->deleteJson('/api/user/' . $fakeUser->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Sucesso',
            ]);
    }
}
