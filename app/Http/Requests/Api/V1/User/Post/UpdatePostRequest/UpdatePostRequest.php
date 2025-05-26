<?php

namespace App\Http\Requests\Api\V1\User\Post\UpdatePostRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
{
    use HandleApiJsonResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => 'sometimes|required|string|max:255',
            'content'         => 'sometimes|required|string',
            'image_url'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scheduled_time'  => 'required_if:status,1||nullable|date|after_or_equal:now',
            'status'          => 'sometimes|required|in:0,1,2',
            'platform_ids'    => 'nullable|array|min:1',
            'platform_ids.*'  => 'nullable|exists:platforms,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorValidate($validator));
    }
}
