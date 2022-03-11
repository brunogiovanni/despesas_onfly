<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return response(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $validated = User::validate($request);
        if ($validated->fails()) {
            return response(['errors' => $validated->errors()], 400);
        }

        $userCreated = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);
        if (!$userCreated) {
            return response(['error' => 'Usuário não pode ser criado'], 400);
        }

        return response(['message' => 'Usuário criado']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): Response
    {
        $user = User::find($id);
        if (!$user) {
            return response(['error' => 'Usuário não encontrado'], 404);
        }

        return response($user);
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
        $validated = User::validate($request);
        if ($validated->fails()) {
            return response(['errors' => $validated->errors()], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response(['error' => 'Usuário não encontrado'], 404);
        }
        $user->name = $request->name;
        $user->email = $request->email;

        if (!$user->save()) {
            return response(['error' => 'Usuário não pode ser atualizado'], 400);
        }

        return response(['message' => 'Usuário atualizado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): Response
    {
        $user = User::find($id);
        if (!$user) {
            return response(['error' => 'Usuário não encontrado'], 404);
        }

        if (!User::destroy($id)) {
            return response(['error' => 'Erro ao excluir usuário'], 400);
        }

        return response(['message' => 'Usuário excluído com sucesso']);
    }
}
