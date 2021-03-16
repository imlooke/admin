<?php

return [
    'auth' => [
        'failed'          => '用户名或密码错误。',
        'password'        => '密码错误。',
        'throttle'        => '您尝试的登录次数过多，请 :seconds 秒后再试。',
        'unauthenticated' => '用户未经认证。',
        'disabled'        => '当前用户已被禁用。',
    ],

    'success' => [
        'store'       => '创建成功！',
        'update'      => '更新成功！',
        'destroy'     => '删除成功！',
        'clear_cache' => '缓存清除成功！',
    ],

    'permissions' => [
        'no_permissions'       => '用户没有正确的权限：',
        'no_roles'             => '用户没有正确的角色：',
        'access_denied'        => '用户没有权限访问当前资源。',
        'invalid_route_method' => '无效的HTTP方法。',
    ],

    'menus' => [
        'cannot_delete' => '当前菜单下存在子菜单，不能删除。',
        'update_order'  => '排序更新成功。',
    ],

    'settings' => [
        'already_at_top'       => '已经在顶部了。',
        'already_at_bottom'    => '已经在底部了。',
        'moved_order_up'       => '已将 :name 设置抬升。',
        'moved_order_down'     => '已将 :name 设置下沉。',
    ],
];
