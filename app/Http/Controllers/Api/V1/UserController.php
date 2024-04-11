<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    public function currentUser(Request $request): array
    {
        return self::success($request->user());
    }
}
