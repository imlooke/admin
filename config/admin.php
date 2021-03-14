<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin install directory
    |--------------------------------------------------------------------------
    |
    | Here are default directory for Imlooke-admin,
    | and the default is `app/Admin`.
    |
    */

    'directory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin route settings
    |--------------------------------------------------------------------------
    |
    | Here are default route settings for Imlooke-admin,
    |
    */

    'route' => [

        'prefix' => 'admin',

    ],

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin auth settings
    |--------------------------------------------------------------------------
    |
    | Here are default auth settings for Imlooke-admin,
    |
    */

    'auth' => [
        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admins',
            ],
        ],

        'providers' => [
            'admins' => [
                'driver' => 'eloquent',
                'model' => Imlooke\Admin\Models\Administrator::class,
            ],
        ],

        'expiration' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for Imlooke-admin.
    |
    */

    'database' => [

        // Users table & model
        'users_table' => 'admin_users',
        'users_model' => Imlooke\Admin\Models\Administrator::class,

        // Roles table & model
        'roles_table' => 'admin_roles',
        'roles_model' => Imlooke\Admin\Models\Role::class,

        // Permissions table & model
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Imlooke\Admin\Models\Permission::class,

        // Menus table & model
        'menus_table' => 'admin_menus',
        'menus_model' => Imlooke\Admin\Models\Menu::class,

        // Pivot table for table above.
        'user_role_table' => 'admin_user_role',
        'user_permission_table' => 'admin_user_permission',
        'role_permission_table' => 'admin_role_permission',
        'role_menu_table' => 'admin_role_menu',

    ],

];
