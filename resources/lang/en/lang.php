<?php

return [
    'auth' => [
        'failed'          => 'These credentials do not match our records.',
        'password'        => 'The provided password is incorrect.',
        'throttle'        => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthenticated' => 'Unauthenticated.',
    ],

    'success' => [
        'store'   => 'Create completed!',
        'update'  => 'Update completed!',
        'destroy' => 'Destroy completed!',
    ],

    'permissions' => [
        'no_permissions'       => 'User does not have the right permissions: ',
        'no_roles'             => 'User does not have the right roles: ',
        'access_denied'        => 'User does not have the right to access current resources.',
        'invalid_route_method' => 'Invalid route method.',
    ],

    'menus' => [
        'cannot_delete' => 'Current menu has sub menus, cannot delete.',
        'update_order'  => 'Update order complete.',
    ],
];
