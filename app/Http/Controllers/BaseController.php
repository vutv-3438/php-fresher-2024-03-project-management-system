<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public static function NotFound($message = '')
    {
        abort(Response::HTTP_NOT_FOUND, $message);
    }

    public static function Forbidden($message = '')
    {
        abort(Response::HTTP_FORBIDDEN, $message);
    }

    public static function UnAuthorize($message = '')
    {
        abort(Response::HTTP_UNAUTHORIZED, $message);
    }

    public static function Success($message = '')
    {
        abort(Response::HTTP_OK, $message);
    }

    public static function ServerError($message = '')
    {
        abort(Response::HTTP_INTERNAL_SERVER_ERROR, $message);
    }
}
