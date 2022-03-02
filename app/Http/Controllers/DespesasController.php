<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class DespesasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Despesa::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\DespesaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        if (!$validated) {
            throw new \Illuminate\Validation\ValidationException($validated);
        }

        Despesa::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data' => $request->data,
            'users_id' => $request->users_id,
        ]);

        return response(['message' => 'Sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $despesa = Despesa::find($id);
        if ($despesa) {
            return response(Despesa::find($id));
        }

        return response(['message' => 'Nada encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DespesaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validated();
        if (!$validated) {
            throw new \Illuminate\Validation\ValidationException($validated);
        }

        $despesa = Despesa::findOrFail($id);

        $despesa->descricao = $request->descricao;
        $despesa->valor = $request->valor;
        $despesa->data = $request->data;

        $despesa->save();

        return response(['message' => 'Sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Despesa::destroy($id)) {
            return response(['message' => 'Apagado com sucesso']);
        }

        return response(['message' => 'Erro ao executar ação'], 400);
    }
}
