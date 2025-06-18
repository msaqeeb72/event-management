<?php

namespace App\Http\Controllers;

use App\Domain\Repo\UserRepository;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }
    
    public function createUser(UserRequest $request)
    {
        $result = $this->userRepository->createUser(
            [
                "name"=>$request->input("name"),
                "email"=>$request->input("email"),
                "password"=>$request->input("password")
            ]
        );
        if($result){
            return $this->respondSuccess(message:"User Created Successfully.");
        }
        return $this->respondFailed(message:"Unbale to create user.");
    }
}
