<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Despesa;
use Illuminate\Database\Eloquent\Collection;

class DespesaRepository implements DespesaRepositoryInterface
{
    public function getDespesas(): Collection
    {
        return Despesa::with('user')->get();
    }

    public function getDespesasFilter(string $pesquisa): Collection
    {
        return Despesa::with('user')
            ->orWhere('users_id', $pesquisa)
            ->orWhereRelation('user', 'name', 'like', "%$pesquisa%")
            ->get();
    }

    public function getDespesa(int $id): Despesa|null
    {
        return Despesa::find($id);
    }

    public function createDespesa(array $dados): Despesa|null
    {
        return Despesa::create($dados);
    }

    public function updateDespesa(int $id, array $dados): int
    {
        return Despesa::whereId($id)->update($dados);
    }

    public function deleteDespesa(int $id): int
    {
        return Despesa::destroy($id);
    }
}
