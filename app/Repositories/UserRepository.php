<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUsers(): Collection
    {
        return User::all();
    }

    public function getUser(int $id): User|null
    {
        return User::find($id);
    }

    public function createUser(array $dados): User|null
    {
        return User::create($dados);
    }

    public function updateUser(int $id, array $dados): int
    {
        return User::whereId($id)->update($dados);
    }

    public function deleteUser(int $id): int
    {
        return User::destroy($id);
    }
}
