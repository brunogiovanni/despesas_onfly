<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DespesasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $despesas = new Despesa;
        if ($request->pesquisa) {
            return response(
                $despesas
                    ->whereRelation('user', 'name', 'like', "%$request->pesquisa%")
                    ->orWhere('users_id', $request->pesquisa)
                    ->with('user')
                    ->get()
            );
        }

        return response(
            $despesas->with('user')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $validated = Despesa::validate($request);
        if ($validated->fails()) {
            return response(['errors' => $validated->errors()], 400);
        }

        $despesa = Despesa::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data' => $request->data,
            'users_id' => auth()->user()->id,
        ]);

        if (!$despesa) {
            return response(['erro' => 'Erro ao cadastrar despesa'], 400);
        }
        // Mail::to(auth()->user()->email)
        //     ->queue(new DespesaMail($despesa));
        dispatch(new SendMailJob(auth()->user()->email, $despesa));

        return response(['message' => 'Sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): Response
    {
        $despesa = Despesa::find($id);
        if ($despesa) {
            return response(Despesa::find($id));
        }

        return response(['error' => 'Nada encontrado'], 404);
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
        $validated = Despesa::validate($request);
        if ($validated->fails()) {
            return response(['errors' => $validated->errors()], 400);
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
    public function destroy(int $id): Response
    {
        $despesa = Despesa::find($id);
        if (!$despesa) {
            return response(['error' => 'Despesa não encontrada'], 400);
        }
        if (Despesa::destroy($id)) {
            return response(['message' => 'Apagado com sucesso']);
        }

        return response(['error' => 'Erro ao executar ação'], 400);
    }
}
