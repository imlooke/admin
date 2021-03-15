<?php

namespace Imlooke\Admin;

use Imlooke\Admin\Models\Administrator;
use Imlooke\Admin\Models\Menu;
use Imlooke\Admin\Models\Permission;
use Imlooke\Admin\Models\Role;

/**
 * DatabaseInstaller
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class DatabaseInstaller
{
    /**
     * Create administrator role.
     *
     * @return void
     */
    protected function createAdministratorRole()
    {
        Role::create([
            'name' => '超级管理员',
            'slug' => 'administrator',
        ]);

        // add administrator role to user
        Administrator::first()->roles()->save(Role::first());
    }

    /**
     * Create permissions.
     *
     * @return void
     */
    protected function createPermissions()
    {
        Permission::insert([
            [
                'name'         => 'Dashboard',
                'slug'         => 'admin.dashboard',
                'route_path'   => '/dashboard',
                'route_method' => 'GET',
            ],
            [
                'name'         => 'Admin Users',
                'slug'         => 'admin.users',
                'route_path'   => '/auth/users/*',
                'route_method' => '',
            ],
            [
                'name'         => 'Admin Roles',
                'slug'         => 'admin.roles',
                'route_path'   => '/auth/roles/*',
                'route_method' => '',
            ],
            [
                'name'         => 'Admin Permissions',
                'slug'         => 'admin.permissions',
                'route_path'   => '/auth/permissions/*',
                'route_method' => '',
            ],
            [
                'name'         => 'Admin Menus',
                'slug'         => 'admin.menus',
                'route_path'   => '/auth/menus/*',
                'route_method' => '',
            ],
        ]);

        // add permissions to administrator role
        Role::first()->permissions()->attach(
            Permission::all()->pluck('id')
        );
    }

    /**
     * Create menus.
     *
     * @return void
     */
    protected function createMenus()
    {
        $menus = [
            [
                'parent_id'  => 0,
                'order'      => 1,
                'name'       => 'Dashboard',
                'route_path' => '/dashboard',
                'icon'       => '',
            ],
            [
                'parent_id'  => 0,
                'order'      => 2,
                'name'       => 'Admin',
                'route_path' => '',
                'icon'       => '',
            ],
            [
                'parent_id'  => 2,
                'order'      => 1,
                'name'       => 'Users',
                'route_path' => '/users',
                'icon'       => '',
            ],
            [
                'parent_id'  => 2,
                'order'      => 2,
                'name'       => 'Roles',
                'route_path' => '/roles',
                'icon'       => '',
            ],
            [
                'parent_id'  => 2,
                'order'      => 3,
                'name'       => 'Permissions',
                'route_path' => '/permissions',
                'icon'       => '',
            ],
            [
                'parent_id'  => 2,
                'order'      => 4,
                'name'       => 'Menus',
                'route_path' => '/menus',
                'icon'       => '',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }

    /**
     * Create administrator user.
     *
     * @param  string $username
     * @param  string $password
     * @return void
     */
    public function createAdministratorUser(string $username = null, string $password = null)
    {
        Administrator::create([
            'username' => $username ?: 'admin',
            'password' => $password ? bcrypt($password) : bcrypt('123456'),
            'name'     => '超级管理员',
        ]);
    }

    /**
     * Create database.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdministratorUser();
        $this->createAdministratorRole();
        $this->createPermissions();
        $this->createMenus();
    }
}
