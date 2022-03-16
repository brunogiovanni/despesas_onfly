<?php

namespace Tests\Unit;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DespesaTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, RefreshDatabase;

    /**
     * Teste de listagem
     *
     * @return void
     */
    public function testIndex()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        Despesa::factory()->count(5)->create()->toArray();

        $response = $this->getJson('/api/despesas');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "id",
                    "descricao",
                    "valor",
                    "data",
                    "users_id",
                    "created_at",
                    "updated_at",
                    "user" => [
                        "id",
                        "name",
                        "email",
                        "email_verified_at",
                        "created_at",
                        "updated_at",
                    ]
                ],
            ]);
    }

    /**
     * Teste de listagem com pesquisa
     *
     * @return void
     */
    public function testIndexSearch()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        Despesa::factory()->count(5)->create()->toArray();

        $response = $this->getJson("/api/despesas?pesquisa=1");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "id",
                    "descricao",
                    "valor",
                    "data",
                    "users_id",
                    "created_at",
                    "updated_at",
                    "user" => [
                        "id",
                        "name",
                        "email",
                        "email_verified_at",
                        "created_at",
                        "updated_at",
                    ]
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
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->postJson('/api/despesa', []);

        $response
            ->assertStatus(400)
            ->assertJsonFragment(['descricao' => ["Descreva a despesa"]]);
    }

    /**
     * Teste de armazenamento
     *
     * @return void
     */
    public function testStore()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeDespesa = Despesa::factory()->create()->toArray();
        $response = $this->postJson('/api/despesa', $fakeDespesa);

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

        $fakeDespesa = Despesa::factory()->create();
        $response = $this->putJson('/api/despesa/' . $fakeDespesa->id, [...$fakeDespesa->toArray(), 'valor' => 1234]);

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

        $fakeDespesa = Despesa::factory()->create();
        $response = $this->deleteJson('/api/despesa/' . $fakeDespesa->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Sucesso',
            ]);
    }
}
