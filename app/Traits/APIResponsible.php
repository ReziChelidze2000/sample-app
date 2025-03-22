<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use function response;

trait APIResponsible
{
    public function baseResponse(
        string $message = null,
        mixed $data = null,
        int $code = Response::HTTP_OK
    ): JsonResponse {
        if ($data instanceof AnonymousResourceCollection) {
            return $data->additional(array_merge($data->additional, ['message' => $message]))
                ->response()
                ->setStatusCode($code);
        } else {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $code);
        }
    }

    public function success(string $message = null, $data = null): JsonResponse
    {
        return $this->baseResponse($message, $data);
    }

    public function error(
        string $message = null,
        mixed $data = null,
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY
    ): JsonResponse {
        return $this->baseResponse($message, $data, $code);
    }

    public function exception(Throwable $exception, string $message = null): JsonResponse
    {
        report($exception);

        return $this->baseResponse(message: $message, code: Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function validatorError(Validator $validator, string $message = null): JsonResponse
    {
        return $this->error($message, $validator->errors());
    }
}
