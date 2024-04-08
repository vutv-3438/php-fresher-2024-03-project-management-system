<?php

namespace App\Http\Controllers;

use App\Common\Enums\Http\StatusCode;

class BaseController extends Controller
{
    public static function NotFound()
    {
        abort(StatusCode::NOT_FOUND);
    }

    public static function Forbidden($message = '')
    {
        abort(StatusCode::FORBIDDEN, $message);
    }

    public static function UnAuthorize()
    {
        abort(StatusCode::UNANTHORIZE);
    }

    public static function Success($message = '')
    {
        abort(StatusCode::SUCCESS, $message);
    }

    public static function ServerError()
    {
        abort(StatusCode::SERVER_ERROR);
    }
}
