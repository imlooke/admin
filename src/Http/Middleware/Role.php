<?php

namespace Imlooke\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Imlooke\Admin\Exceptions\UnauthorizedException;
use Imlooke\Admin\Facades\Admin;

/**
 * Role
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Role
{
    /**
     * Check user roles.
     *
     * @param  Request $request
     * @param  Closure $next
     * @param  array ...$roles
     * @return void
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Admin::guard()->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        foreach ($roles as $role) {
            if (Admin::user()->hasRole($role)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forRoles($roles);
    }
}
