<?php
namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {
    public function create(array $data):User;

    public function createMember(array $data): User;

    public function findById(string $id): ?User;

    public function userCount(string $userType): int;

    public function fetch($limit, array $data);

    public function update($user, array $data);

    public function updatePassword(string $password, $user);
}
