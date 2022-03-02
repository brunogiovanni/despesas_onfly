<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    private $userRequest;

    public function __construct()
    {
        $this->userRequest = new UserRequest();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), $this->userRequest->rules(), $this->userRequest->messages());
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
    public function show($id)
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
    public function update(Request $request, $id)
    {
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
    public function destroy($id)
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
