<?php

namespace Imlooke\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

/**
 * AdminServiceProvider
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class AdminServiceProvider extends ServiceProvider
{
    /**
     * Commands.
     *
     * @var array
     */
    protected $commands = [
        Console\InstallCommand::class,
        Console\UninstallCommand::class,
        Console\AssetsLinkCommand::class,
    ];

    /**
     * The admin's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin.api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]
    ];

    /**
     * The admin's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => \Imlooke\Admin\Http\Middleware\Authenticate::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadAdminConfig();
        $this->registerRouteMiddleware();

        // register the base admin service
        $this->app->singleton('imlooke.admin', function () {
            return new Admin;
        });

        // register commands
        $this->commands($this->commands);
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }

    /**
     * Load admin configuration.
     *
     * @return void
     */
    protected function loadAdminConfig()
    {
        config(Arr::dot(config('admin.auth', []), 'auth.'));

        config([
            'sanctum.guard' => config('sanctum.guard') ?: config('admin.auth.guard'),
            'sanctum.expiration' => config('sanctum.expiration') ?: config('admin.auth.expiration'),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        $this->registerPublishing();

        if (file_exists($routes = admin_path('routes.php'))) {
            $this->loadRoutesFrom($routes);
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config' => config_path()
            ], 'imlooke-admin-config');
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations')
            ], 'imlooke-admin-migrations');
        }
    }
}
