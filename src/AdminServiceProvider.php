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
     * Register services.
     *
     * @return void
     */
    public function register()
    {

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
            $this->publishes([__DIR__.'/../config' => config_path()], 'imlooke-admin-config');
        }
    }
}
