<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for Imlooke-admin builtin model & tables.
    |
    */

    'database' => [

        // Users table & model
        'users_table' => 'admin_users',
        'users_model' => Imlooke\Admin\Auth\Models\Administrator::class,

        // Roles table & model
        'roles_table' => 'admin_roles',
        'roles_model' => Imlooke\Admin\Auth\Models\Role::class,

        // Permissions table & model
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Imlooke\Admin\Auth\Models\Permission::class,

        // Menus table & model
        'menus_table' => 'admin_menus',
        'menus_model' => Imlooke\Admin\Auth\Models\Menu::class,

        // Pivot table for table above.
        'user_role_table' => 'admin_user_role',
        'user_permission_table' => 'admin_user_permission',
        'role_permission_table' => 'admin_role_permission',
        'role_menu_table' => 'admin_role_menu',

    ],

];
