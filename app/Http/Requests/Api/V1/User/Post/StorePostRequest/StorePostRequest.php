<?php

namespace App\Http\Requests\Api\V1\User\Post\StorePostRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StorePostRequest extends FormRequest
{
    use HandleApiJsonResponseTrait;
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
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'image_url'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scheduled_time'  => 'required_if:status,1|date|after_or_equal:now',
            'status'          => 'required|in:0,1,2',
            'platform_ids'    => 'required|array|min:1',
            'platform_ids.*'  => 'required|exists:platforms,id'
        ];
    }
    
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->errorValidate($validator));
    }
}