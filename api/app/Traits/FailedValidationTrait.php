<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait FailedValidationTrait
{
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                ['status' => false, 'errors' => $errors],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
