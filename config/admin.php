<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Imlooke-admin table names
    |--------------------------------------------------------------------------
    |
    | Here are table names for Imlooke-admin builtin model & tables.
    |
    */

    'table_names' => [

        'admins' => 'admins',

        'roles' => 'roles',

        'permissions' => 'permissions',

        'menus' => 'menus',

        // Pivot table for table above.
        'admin_role' => 'admin_role',
        'admin_permission' => 'admin_permission',
        'role_permission' => 'role_permission',
        'role_menu' => 'role_menu',

    ],

];
