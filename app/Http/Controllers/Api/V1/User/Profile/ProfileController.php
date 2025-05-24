<?php

namespace App\Http\Controllers\Api\V1\User\Profile;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource\UserResource;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use App\Http\Requests\Api\V1\User\Profile\UpdateProfileRequest\UpdateProfileRequest;
use App\Services\UserService\UserService;

class ProfileController extends Controller
{
    use HandleApiJsonResponseTrait;
    public function __construct(
        protected UserService $userService,
    ) {}

    public function show()
    {
        try {
            $user = auth('sanctum')->user();
            return $this->success([
                'user'  => UserResource::make($user),
                'token' => null
            ], __('api.successfully') );

        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = auth('sanctum')->user();
            $data = $this->userService->update($user, $request->validated() );
            return $this->success([
                'user'  => UserResource::make($data['user']),
                'token' => null
            ], __('api.User updated successfully') );

        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
    public function logout(Request $request)
    {
        try {
            auth('sanctum')->user()->currentAccessToken()->delete();
            return $this->success([], __('api.Logout Successfully') );

        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}