<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface DespesaServiceInterface
{
    public function getDespesas(Request $request): Collection;
    public function getDespesa(int $id): array;
    public function createDespesa(Request $request): array;
    public function updateDespesa(int $id, Request $request): array;
    public function deleteDespesa(int $id): array;
}
