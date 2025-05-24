<?php

namespace App\Http\Requests\Api\V1\User\Profile\UpdateProfileRequest;

use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    use HandleApiJsonResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth('sanctum')->user()?->id;

        return [
            'name'            => ['required', 'string', 'max:150'],
            'email'           => ['required', 'email', "unique:users,email,{$userId}"],
            'password'        => [
                                    'sometimes',
                                    'string',
                                    Password::min(8)
                                        ->mixedCase()
                                        ->letters()
                                        ->numbers()
                                        ->symbols()
                                        ->uncompromised(),
                                    'max:50',
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorValidate($validator));
    }
}
