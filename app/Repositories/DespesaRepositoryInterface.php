<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Despesa;
use Illuminate\Database\Eloquent\Collection;

interface DespesaRepositoryInterface
{
    public function getDespesas(): Collection;
    public function getDespesasFilter(string $pesquisa): Collection;
    public function getDespesa(int $id): Despesa|null;
    public function createDespesa(array $dados): Despesa|null;
    public function updateDespesa(int $id, array $dados): int;
    public function deleteDespesa(int $id): int;
}
