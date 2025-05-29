<?php

namespace App\Http\Controllers\Api\V1\User\Authentication\Register;

use Throwable;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource\UserResource;
use App\Services\RegisterUserService\RegisterUserService;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use App\Http\Requests\Api\V1\User\Register\RegisterUserRequest\RegisterUserRequest;

class RegisterController extends Controller
{
    use HandleApiJsonResponseTrait;
    public function __construct(
        protected RegisterUserService $registerUserService,
    ) {}

    public function register(RegisterUserRequest $request)
    {
        try {
            $data = $this->registerUserService->register( $request->validated() );
            return $this->success([
                'user'  => UserResource::make($data['user']),
                'token' => $data['token']
            ], __('api.User registered successfully') );
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}
