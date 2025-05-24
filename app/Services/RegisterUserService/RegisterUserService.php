<?php

namespace App\Services\RegisterUserService;

use App\Models\User;
use App\Repositories\UserRepository\UserRepository;

class RegisterUserService
{
    public function __construct(protected UserRepository $userRepository) {}

    public function register(array $data): array
    {
        $user  = $this->userRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user'  => $user,
            'token' => $token
        ];
    }
}
