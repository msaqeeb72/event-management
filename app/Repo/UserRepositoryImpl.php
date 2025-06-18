<?php

namespace App\Repo;

use App;
use App\Domain\Repo\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImpl implements UserRepository{

    /**
     * @inheritDoc
     */
    public function createUser($userData): User {
        return User::create([
            'name'     => $userData["name"],
            'email'    => $userData["email"],
            'password' => Hash::make($userData["password"]),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function deleteUser($userId): int {
        return User::destroy($userId);
    }

    /**
     * @inheritDoc
     */
    public function getUser($userId): User {
        return User::findOrFail($userId);
    }

    /**
     * @inheritDoc
     */
    public function updateUser($userId, $userData): User {
        $user = User::findOrFail($userId);

        $user->name  = $userData["name"] ?? $user->name;
        $user->email = $userData["email"] ?? $user->email;
        $user->save();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getUserByEmail($email): User {
        return User::where("email",$email)->firstOrFail();
    }
}