<?php


namespace Controllers\Contracts;

use Models\Users\User;

interface UserInterface
{
    public function select(int $id): User;
    public function insert(User $user): User;
    public function update(User $user): bool;
    public function delete(int $id): bool;
    public function checkUser(User $user): User;
}