<?php

namespace Imlooke\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    protected $namespace = 'Imlooke\\Admin\\Http\\Controllers';

    /**
     * Attempt to get the guard.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        $guard = config('admin.auth.guard') ?: 'admin';

        return Auth::guard($guard);
    }

    /**
     * Register admin routes.
     *
     * @return void
     */
    public function routes()
    {
        $this->registerSpaRoutes();
        $this->registerApiRoutes();
    }

    /**
     * Register admin spa routes.
     *
     * @return void
     */
    public function registerSpaRoutes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'namespace' => $this->namespace,
            'middleware' => 'web'
        ];

        Route::group($attributes, function ($router) {
            $router->get('/{any?}', 'IndexController@index')->where('any', '.*');
        });
    }

    /**
     * Register admin api routes.
     *
     * @return void
     */
    public function registerApiRoutes()
    {
        $attributes = [
            'prefix' => 'api/admin',
            'namespace' => $this->namespace,
            'middleware' => 'admin.api'
        ];

        Route::group($attributes, function ($router) {
            $router->post('/login', 'AuthController@login');

            $router->middleware(['admin.auth:sanctum'])->group(function ($router) {
                $router->post('/logout', 'AuthController@logout');
                $router->get('/user', 'UserController@user');
                $router->put('/user', 'UserController@update');
                $router->post('/reset', 'UserController@reset');
            });

            $router->middleware(['admin.auth:sanctum'])->group(function ($router) {
                $router->apiResources([
                    'auth/users' => 'UsersController',
                    'auth/roles' => 'RolesController',
                    'auth/permissions' => 'PermissionsController',
                ]);
            });
        });
    }
}
