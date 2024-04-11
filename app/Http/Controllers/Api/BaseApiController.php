<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseApiController extends Controller
{
    protected string $guard = 'api';

    public static function success($data, $message = ''): array
    {
        return [
            'message' => $message,
            'data' => $data,
            'status' => Response::HTTP_OK,
        ];
    }

    public static function forbidden($message = "You don't have permission!"): array
    {
        return [
            'message' => $message,
            'status' => Response::HTTP_FORBIDDEN,
        ];
    }

    public static function notFound($message = 'Not found!'): array
    {
        return [
            'message' => $message,
            'status' => Response::HTTP_NOT_FOUND,
        ];
    }

    public static function badRequest($message = 'Check your information again!'): array
    {
        return [
            'message' => $message,
            'status' => Response::HTTP_BAD_REQUEST,
        ];
    }

    public static function serverError($message = 'Something went wrong!'): array
    {
        return [
            'message' => $message,
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
        ];
    }
}
