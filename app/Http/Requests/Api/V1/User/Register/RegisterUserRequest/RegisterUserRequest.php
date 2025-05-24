<?php

namespace App\Http\Requests\Api\V1\User\Register\RegisterUserRequest;

use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:150'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => [
                                'required', 
                                'string',
                                Password::min(8)
                                ->mixedCase()
                                ->letters()    
                                ->numbers()   
                                ->symbols()
                                ->uncompromised(),
                                'max:50'
                            ]
        ];
    }

    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->errorValidate($validator));
    }
}
