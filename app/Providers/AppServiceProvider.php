<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityRequirement;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\RouteInfo;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->components->securitySchemes['sanctum'] =
                    SecurityScheme::http('bearer');
            })
            ->withOperationTransformers(function (
                Operation $operation,
                RouteInfo $routeInfo
            ) {
                $middleware = $routeInfo->route->gatherMiddleware();

                if (in_array('auth:sanctum', $middleware, true)) {
                    $operation->security = [
                        new SecurityRequirement([
                            'sanctum' => [],
                        ]),
                    ];
                }
        });
    }
}
