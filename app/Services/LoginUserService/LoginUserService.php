<?php

namespace App\Services\LoginUserService;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserRepository\UserRepository;

class LoginUserService
{    
    public function __construct(protected UserRepository $userRepository) {}

    public function login(array $credentials): array
    {
        $user  = $this->userRepository->findByEmail( $credentials['email'] );
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('api.Invalid credentials.')],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user'  => $user,
            'token' => $token
        ];
    }
}
