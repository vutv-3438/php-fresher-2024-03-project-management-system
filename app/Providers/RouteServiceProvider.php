<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    private array $apiV1RouteFiles = [
        'issue',
        'user',
    ];

    private array $webRouteFiles = [
        'main',
        'project',
        'work-flow',
        'work-flow-step',
        'issue',
        'role',
        'issue-type',
        'log-time',
        'role-claim',
        'member',
        'user',
    ];

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->configureApiV1Routes();
            $this->configureWebRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function configureApiV1Routes()
    {
        Route::prefix('api/v1')
            ->middleware(['api', 'auth:api'])
            ->namespace($this->namespace)
            ->name('api.')
            ->group(function () {
                foreach ($this->apiV1RouteFiles as $file) {
                    $routePath = base_path("routes/api/v1/{$file}.php");
                    Route::group([], $routePath);
                }
            });
    }

    protected function configureWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                foreach ($this->webRouteFiles as $file) {
                    $routePath = base_path("routes/web/{$file}.php");
                    Route::group([], $routePath);
                }
            });
    }
}
