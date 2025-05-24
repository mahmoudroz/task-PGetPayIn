<?php

namespace App\Http\Requests\Api\v1\User\Login\LoginUserRequest;

use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class LoginUserRequest extends FormRequest
{
    use HandleApiJsonResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'max:50']
        ];
    }

    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->errorValidate($validator));
    }
}
