<?php

use Illuminate\Http\RedirectResponse;
use App\Common\Enums\Status;

if (!function_exists('getActionSuffix')) {
    function getActionSuffix(string $action): string
    {
        return str_ends_with($action, 'e') ? 'd' : 'ed';
    }
}

if (!function_exists('redirectWithActionStatus')) {
    function redirectWithActionStatus(
        string $status,
        string $route,
        string $object,
        string $action,
        array  $params = []
    ): RedirectResponse
    {
        $message = __("The :object has been $action" . getActionSuffix($action), ['object' => $object]);

        return redirect()->route($route, $params)->with([
            'type' => in_array($status, Status::toArray()) ? $status : Status::SUCCESS,
            'msg' => $message,
        ]);
    }
}

if (!function_exists('backWithActionStatus')) {
    /**
     * The common error will be show if you don't pass any params
     *
     * @param string|null $object
     * @param string|null $action
     * @param string|null $status
     * @return RedirectResponse
     */
    function backWithActionStatus(string $object = null, string $action = null, string $status = null): RedirectResponse
    {
        $message = $status ? __('Something went wrong') : __("The :object has been $action" . getActionSuffix($action), ['object' => $object]);
        $type = in_array($status, Status::toArray()) ? $status : Status::DANGER;

        return back()->with([
            'type' => $type,
            'msg' => $message,
        ]);
    }
}
