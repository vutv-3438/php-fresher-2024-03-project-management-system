<?php

namespace App\Http\Middleware;

use App\Common\CommonResponseDto;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiResponseHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $jsonData = $response->getData();
        $isSuccess = (isset($jsonData->status) && $jsonData->status === 200) ||
            $jsonData->success === true;

        if (
            $isSuccess &&
            $response->headers->get('Content-Type') === 'application/json'
        ) {
            $response = self::handleJsonReponse($response);
        }

        return $response;
    }

    public static function handleJsonReponse($response): JsonResponse
    {
        $data = json_decode($response->getContent(), true);

        return new JsonResponse(
            new CommonResponseDto(
                true,
                $response->getStatusCode(),
                $data['message'],
                [],
                $data['data'] ?? null
            )
        );
    }
}
