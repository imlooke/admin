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
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config' => config_path()], 'imlooke-admin-config');
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'imlooke-admin-migrations');
        }
    }
}
