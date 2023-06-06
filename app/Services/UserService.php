<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserService
{
    
    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
    
    public function register(array $data): User
    {
        // Create and save the user
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return $user;
    }

    public function login(array $credentials): ?string
    {
        // Attempt to authenticate the user
        if (!auth()->attempt($credentials)) {
            return null;
        }

        // Generate JWT token for the authenticated user
        $token = JWTAuth::fromUser(auth()->user());

        return $token;
    }
}