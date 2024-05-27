<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseError(Response::HTTP_BAD_REQUEST, 'BAD_REQUEST', $validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
