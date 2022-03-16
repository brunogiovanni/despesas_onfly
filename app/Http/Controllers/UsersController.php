<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return response($this->userService->getUsers());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $result = $this->userService->createUser($request);

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
        $result = $this->userService->getUser($id);

        return response(['message' => $result['message']], $result['status']);
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
        $result = $this->userService->updateUser($id, $request);

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
        $result = $this->userService->deleteUser($id);

        return response(['message' => $result['message']], $result['status']);
    }
}
