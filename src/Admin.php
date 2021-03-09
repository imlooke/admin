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
     * Register admin routes.
     *
     * @return void
     */
    public function routes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
        ];

        app('router')->group($attributes, function ($router) {
            $router->get('/login', '\Imlooke\Admin\Controllers\AuthController@getLogin');
        });
    }
}
