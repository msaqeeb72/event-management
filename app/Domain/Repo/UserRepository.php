<?php

namespace App\Domain\Repo;

use App\Models\User;

interface UserRepository{
    public function createUser($userData) : User;
    public function updateUser($userId, $userData) : User;

    public function deleteUser($userId) : int;

    public function getUser($userId):User;
    public function getUserByEmail($email):User;
}