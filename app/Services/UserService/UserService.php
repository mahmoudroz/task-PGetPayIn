<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Repositories\UserRepository\UserRepository;

class UserService
{
    public function __construct(protected UserRepository $userRepository) {}

    public function update(User $user, array $data): array
    {
        $user  = $this->userRepository->update($user, $data);
        return [
            'user'  => $user,
        ];
    }
}
