<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getUsers(): Collection;
    public function getUser(int $id): User|null;
    public function createUser(array $dados): User|null;
    public function updateUser(int $id, array $dados): int;
    public function deleteUser(int $id): int;
}
