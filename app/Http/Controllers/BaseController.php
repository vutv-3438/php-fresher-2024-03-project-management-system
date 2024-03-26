<?php

namespace App\Http\Controllers;

use App\Common\Enums\Http\StatusCode;

class BaseController extends Controller
{
    public static function NotFound()
    {
        return abort(StatusCode::NOT_FOUND);
    }

    public static function Forbidden()
    {
        return abort(StatusCode::FORBIDDEN);
    }

    public static function UnAuthorize()
    {
        return abort(StatusCode::UNANTHORIZE);
    }

    public static function Success()
    {
        return abort(StatusCode::SUCCESS);
    }

    public static function ServerError()
    {
        return abort(StatusCode::SERVER_ERROR);
    }
}
