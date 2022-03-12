<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\DespesaServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DespesasController extends Controller
{
    public function __construct(
        private DespesaServiceInterface $despesaService
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $despesas = $this->despesaService->getDespesas($request);

        return response($despesas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $result = $this->despesaService->createDespesa($request);

        return response(['message' => $result['message']], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): Response
    {
        $result = $this->despesaService->getDespesa($id);

        return response($result['message'], $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): Response
    {
        $result = $this->despesaService->updateDespesa($id, $request);

        return response(['message' => $result['message']], $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): Response
    {
        $result = $this->despesaService->deleteDespesa($id);

        return response(['message' => $result['message']], $result['status']);
    }
}
