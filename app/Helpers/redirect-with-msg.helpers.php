<?php

if (!function_exists('redirectWithSuccess')) {
    function redirectWithSuccess(string $route, string $message, $params = []): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($route, $params)->with([
            'type' => 'success',
            'msg' => $message,
        ]);
    }
}

if (!function_exists('redirectWithSuccessAction')) {
    function getSuffixMsg(string $action): string
    {
        return substr($action, -1) == 'e' ? 'd' : 'ed';
    }

    function redirectWithSuccessAction(
        string $route,
        string $object,
        string $action,
               $params = []
    ): \Illuminate\Http\RedirectResponse
    {
        return redirectWithSuccess($route, __("The :object has been $action" . getSuffixMsg($action), ['object' => $object]), $params);
    }
}

if (!function_exists('redirectWithError')) {
    function redirectWithError($route, $message, $params = []): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($route, $params)->with([
            'type' => 'error',
            'msg' => $message,
        ]);
    }
}


if (!function_exists('backWithCommonError')) {
    function backWithCommonError($params = []): \Illuminate\Http\RedirectResponse
    {
        return back()->with([
            'type' => 'danger',
            'msg' => __('Something went wrong'),
        ]);
    }
}
