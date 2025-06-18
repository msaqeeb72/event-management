<?php

namespace App\Http\Controllers;

use App\Domain\Repo\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function loginUser(AuthRequest $request)
    {
        $user = $this->userRepository->getUserByEmail($request->input("email"));

        if (!$user) {
            return $this->respondFailed(message: "User not found.");
        }

        if (!Hash::check($request->input("password"), $user->password)) {
            return $this->respondFailed(message: "Email-password combination does not match.");
        }

        $token = $user->createToken("web")->plainTextToken;

        return $this->respondSuccess(
            [
                "token" => $token,
                "user"  => $user,
            ],
            message: "Login successful."
        );
    }
}
