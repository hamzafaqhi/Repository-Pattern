<?php

namespace App\Http\Traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


trait ValidationTrait
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->errorResponse($errors, 'Validation error messages', JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Generate a JSON error response.
     *
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(array $data, $message, $statusCode)
    {
        return response()->json(['data' => $data, 'success' => false, 'code' => $statusCode, 'message' => $message], $statusCode);
    }
}