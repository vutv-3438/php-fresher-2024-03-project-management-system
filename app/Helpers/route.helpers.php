<?php

if (!function_exists('getRouteParam')) {
    function getRouteParam(string $param)
    {
        return request()->route()->parameter($param);
    }
}
