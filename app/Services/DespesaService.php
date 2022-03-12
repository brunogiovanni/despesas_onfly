<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Despesa;
use App\Jobs\SendMailJob;
use App\Repositories\DespesaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DespesaService implements DespesaServiceInterface
{
    public function __construct(
        private DespesaRepositoryInterface $despesaRepository
    ) {
    }

    public function getDespesas(Request $request): Collection
    {
        if (!empty($request?->pesquisa)) {
            return $this->despesaRepository->getDespesasFilter($request->pesquisa);
        }

        return $this->despesaRepository->getDespesas();
    }

    public function getDespesa(int $id): array
    {
        $despesa = $this->despesaRepository->getDespesa($id);
        if ($despesa) {
            return ['message' => $despesa, 'status' => 200];
        }

        return ['message' => 'Nada encontrado', 'status' => 404];
    }

    public function createDespesa(Request $request): array
    {
        $validated = Despesa::validate($request);
        if ($validated->fails()) {
            return ['message' => $validated->errors(), 'status' => 400];
        }

        $despesa = $this->despesaRepository->createDespesa($request->all());
        if (!$despesa) {
            return ['message' => 'Não foi possível salvar', 'status' => 400];
        }

        $this->dispatchEmail($despesa);

        return ['message' => 'Sucesso', 'status' => 200];
    }

    private function dispatchEmail(Despesa $despesa): void
    {
        // Mail::to(auth()->user()->email)
        //     ->queue(new DespesaMail($despesa));
        dispatch(new SendMailJob(auth()->user()->email, $despesa));
    }

    public function updateDespesa(int $id, Request $request): array
    {
        $validated = Despesa::validate($request);
        if ($validated->fails()) {
            return ['message' => $validated->errors(), 'status' => 400];
        }
        $despesa = $this->despesaRepository->getDespesa($id);
        if (!$despesa) {
            return ['message', 'Nada encontrado', 'status' => 404];
        }

        if ($this->despesaRepository->updateDespesa($id, $request->all()) < 1) {
            return ['message' => 'Não foi possível atualizar', 'status' => 400];
        }

        return ['message' => 'Sucesso', 'status' => 200];
    }

    public function deleteDespesa(int $id): array
    {
        $despesa = $this->despesaRepository->getDespesa($id);
        if (!$despesa) {
            return ['message', 'Nada encontrado', 'status' => 404];
        }

        if ($this->despesaRepository->deleteDespesa($id) < 1) {
            return ['message' => 'Não foi possível excluir', 'status' => 400];
        }

        return ['message' => 'Sucesso', 'status' => 200];
    }
}
