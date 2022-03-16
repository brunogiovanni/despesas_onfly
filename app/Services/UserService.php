<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function getUsers(): Collection
    {
        return $this->userRepository->getUsers();
    }

    public function getUser(int $id): array
    {
        $user = $this->userRepository->getUser($id);
        if ($user) {
            return ['message' => $user, 'status' => 200];
        }

        return ['message' => 'Nada encontrado', 'status' => 404];
    }

    public function createUser(Request $request): array
    {
        $validated = User::validate($request);
        if ($validated->fails()) {
            return ['message' => $validated->errors(), 'status' => 400];
        }

        $user = $this->userRepository->createUser($request->all());
        if (!$user) {
            return ['message' => 'Não foi possível salvar', 'status' => 400];
        }

        return ['message' => 'Sucesso', 'status' => 200];
    }

    public function updateUser(int $id, Request $request): array
    {
        $validated = User::validate($request);
        if ($validated->fails()) {
            return ['message' => $validated->errors(), 'status' => 400];
        }
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            return ['message', 'Nada encontrado', 'status' => 404];
        }

        if ($this->userRepository->updateUser($id, $request->all()) < 1) {
            return ['message' => 'Não foi possível atualizar', 'status' => 400];
        }

        return ['message' => 'Sucesso', 'status' => 200];
    }

    public function deleteUser(int $id): array
    {
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            return ['message', 'Nada encontrado', 'status' => 404];
        }

        if ($this->userRepository->deleteUser($id) < 1) {
            return ['message' => 'Não foi possível excluir', 'status' => 400];
        }

        return ['message' => 'Sucesso', 'status' => 200];
    }
}
