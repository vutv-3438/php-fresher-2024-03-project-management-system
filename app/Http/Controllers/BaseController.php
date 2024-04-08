<?php

namespace App\Http\Controllers;

use App\Common\Enums\Http\StatusCode;

class BaseController extends Controller
{
    public static function NotFound($message = '')
    {
        abort(StatusCode::NOT_FOUND, $message);
    }

    public static function Forbidden($message = '')
    {
        abort(StatusCode::FORBIDDEN, $message);
    }

    public static function UnAuthorize($message = '')
    {
        abort(StatusCode::UNANTHORIZE, $message);
    }

    public static function Success($message = '')
    {
        abort(StatusCode::SUCCESS, $message);
    }

    public static function ServerError($message = '')
    {
        abort(StatusCode::SERVER_ERROR, $message);
    }
}
