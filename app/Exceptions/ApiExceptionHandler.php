<?php

namespace App\Exceptions;

use App\Common\CommonResponseDto;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiExceptionHandler
{
    public static function handleException(\Exception $exception): JsonResponse
    {
        return new JsonResponse(
            new CommonResponseDto(
                false,
                self::getStatusCode($exception),
                $exception->getMessage(),
                self::getErrorDetails($exception),
            )
        );
    }

    protected static function getStatusCode(\Exception $exception)
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof AuthenticationException) {
            return Response::HTTP_UNAUTHORIZED;
        }

        if ($exception instanceof AuthorizationException) {
            return Response::HTTP_FORBIDDEN;
        }

        if ($exception instanceof ValidationException) {
            return Response::HTTP_BAD_REQUEST;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    protected static function getErrorDetails(\Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $exception->errors();
        }

        return [];
    }
}
