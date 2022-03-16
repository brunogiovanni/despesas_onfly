<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function getUsers(): Collection;
    public function getUser(int $id): array;
    public function createUser(Request $request): array;
    public function updateUser(int $id, Request $request): array;
    public function deleteUser(int $id): array;
}
