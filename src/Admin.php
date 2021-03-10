<?php

namespace Imlooke\Admin;

/**
 * Admin
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Admin
{
    /**
     * The controller namespace for the application.
     *
     * @var string
     */
    protected $namespace = 'Imlooke\\Admin\\Controllers';

    /**
     * Register admin routes.
     *
     * @return void
     */
    public function routes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'namespace' => $this->namespace,
        ];

        app('router')->group($attributes, function ($router) {
            $router->get('/{any?}', 'IndexController@index')->where('any', '.*');
            // $router->get('/login', '\Imlooke\Admin\Controllers\AuthController@getLogin');
        });
    }
}
