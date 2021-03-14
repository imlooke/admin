<?php

namespace Imlooke\Admin;

use Imlooke\Admin\Models\Administrator;
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
        Permission::createMany([
            [
                'name' => 'All permission',
                'slug' => '*',
                'route_path' => '',
                'route_method' => '*',
            ],
            [
                'name' => 'Administrator Manager',
                'slug' => 'admin.manager',
                'route_path' => '',
                'route_method' => "/auth/users\r\n/auth/roles\r\n/auth/permissions\r\n/auth/menus",
            ],
        ]);
    }

    /**
     * Create menus.
     *
     * @return void
     */
    protected function createMenus()
    {
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
            'name' => '超级管理员',
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
