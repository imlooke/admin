<?php

return [
    'auth' => [
        'failed'          => 'These credentials do not match our records.',
        'password'        => 'The provided password is incorrect.',
        'throttle'        => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthenticated' => 'Unauthenticated.',
        'disabled'        => 'Current user has been disabled.',
    ],

    'success' => [
        'store'       => 'Create completed!',
        'update'      => 'Update completed!',
        'destroy'     => 'Destroy completed!',
        'clear_cache' => 'Clear cache completed!',
    ],

    'error' => [
        'missing_parameters' => 'Missing required parameters: :parameters.',
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

    'settings' => [
        'already_at_top'       => 'This is already at the top of the list.',
        'already_at_bottom'    => 'This is already at the bottom of the list.',
        'moved_order_up'       => 'Moved :name setting order up.',
        'moved_order_down'     => 'Moved :name setting order down.',
    ],
];
