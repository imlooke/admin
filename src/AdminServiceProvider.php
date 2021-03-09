<?php

namespace Imlooke\Admin;

use Illuminate\Routing\Router;
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
     * Commands
     *
     * @var array
     */
    protected $commands = [
        Console\InstallCommand::class,
        Console\UninstallCommand::class,
        Console\AssetsLinkCommand::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdmin();

        // register commands
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
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
            $this->publishes([__DIR__ . '/../config' => config_path()]);
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')]);
        }
    }

    /**
     * Register the base admin service.
     *
     * @return void
     */
    protected function registerAdmin()
    {
        $this->app->singleton('imlooke.admin', function () {
            return new Admin;
        });
    }
}
