<?php

namespace App\Http\Requests;
use App\Exceptions\ApiException;
use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ApiException($validator->errors()->first());
    }
}
