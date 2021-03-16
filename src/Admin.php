<?php

namespace Imlooke\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Imlooke\Admin\Models\Setting;

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
        $guard = config('admin.auth.guard', 'admin');

        return Auth::guard($guard);
    }

    /**
     * Attempt to get the user.
     *
     * @return object
     */
    public function user()
    {
        return $this->guard()->user();
    }

    /**
     * Get admin menus.
     *
     * @return array
     */
    public function getMenus()
    {
        return $this->user()->getMenus();
    }

    /**
     * Get setting from database.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function setting($key, $default = null)
    {
        $key = "settings::$key";

        if (Cache::has($key)) {
            return Cache::get($key);
        }

        foreach (Setting::all() as $setting) {
            Cache::forever("settings::{$setting->key}", $setting->value);
        }

        return Cache::has($key) ? Cache::get($key) : $default;
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

            $router->middleware(['admin.auth'])->group(function ($router) {
                $router->post('/logout', 'AuthController@logout');
                $router->get('/user', 'UserController@user');
                $router->put('/user', 'UserController@update');
                $router->post('/reset', 'UserController@reset');
            });

            $router->middleware(['admin.auth', 'admin.permission'])->group(function ($router) {
                $router->get('/auth/actions/clear_cache', 'ActionsController@clearCache');
                $router->post('/auth/users/toggle', 'UsersController@toggle');
                $router->post('/auth/menus/order', 'MenusController@order');

                $router->get('/auth/settings/{id}/move_up', 'SettingsController@moveUp');
                $router->get('/auth/settings/{id}/move_down', 'SettingsController@moveDown');
                $router->apiResource('auth/settings', 'SettingsController')->except(['show']);

                $router->apiResources([
                    'auth/users' => 'UsersController',
                    'auth/roles' => 'RolesController',
                    'auth/permissions' => 'PermissionsController',
                    'auth/menus' => 'MenusController',
                ]);
            });
        });
    }
}
