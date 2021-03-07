<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for Imlooke-admin.
    |
    */

    'database' => [

        // Users table
        'users_table' => 'admin_users',

        // Roles table
        'roles_table' => 'admin_roles',

        // Permissions table
        'permissions_table' => 'admin_permissions',

        // Menus table
        'menus_table' => 'admin_menus',

        // Pivot table for table above.
        'user_role_table' => 'admin_user_role',
        'user_permission_table' => 'admin_user_permission',
        'role_permission_table' => 'admin_role_permission',
        'role_menu_table' => 'admin_role_menu',

    ],

];
