<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $data): ?array
    {
        if (!Auth::attempt($data)) {
            return null;
        }
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(): void
    {
        $user = Auth::user();
        $user?->tokens()->delete();
    }
}
