<?php

namespace App\Http\Controllers\Api\V1\User\Authentication\Login;

use Throwable;
use App\Http\Controllers\Controller;
use App\Services\LoginUserService\LoginUserService;
use App\Http\Resources\Api\V1\UserResource\UserResource;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use App\Http\Requests\Api\v1\User\Login\LoginUserRequest\LoginUserRequest;

class LoginController extends Controller
{
    use HandleApiJsonResponseTrait;
    public function __construct(
        protected LoginUserService $loginUserService,
    ) {}

    public function login(LoginUserRequest $request)
    {
        try {
            $data = $this->loginUserService->login( $request->validated() );
            return $this->success([
                'user'  => UserResource::make($data['user']),
                'token' => $data['token']
            ], __('api.User login successfully') );

        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}

