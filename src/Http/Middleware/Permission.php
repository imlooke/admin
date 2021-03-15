<?php

namespace Imlooke\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Imlooke\Admin\Exceptions\UnauthorizedException;
use Imlooke\Admin\Facades\Admin;

/**
 * Permission
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Permission
{
    /**
     * Check permissions via slug or route path.
     *
     * @param  Request $request
     * @param  Closure $next
     * @param  array ...$permissions
     * @return void
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (Admin::guard()->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if ($this->shouldPass($request)) {
            return $next($request);
        }

        if (!empty($permissions) && $this->check($permissions)) {
            return $next($request);
        }

        $this->checkViaRoute($request);

        return $next($request);
    }

    /**
     * Pass excepts routes.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function shouldPass(Request $request): bool
    {
        $excepts = array_merge([
            'api/admin/login',
            'api/admin/logout',
            'api/admin/user',
            'api/admin/reset',
        ], config('admin.auth.excepts'));

        return collect($excepts)->contains(function ($path) use ($request) {
            return $request->is($path);
        });
    }

    /**
     * Check permissions via slug.
     *
     * @param  array $permissions
     * @return void
     */
    protected function check(array $permissions)
    {
        // has any permission can pass
        foreach ($permissions as $permission) {
            if (Admin::user()->can($permission)) {
                return true;
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }

    /**
     * Check permissions via route path.
     *
     * @param  Request $request
     * @return void
     */
    protected function checkViaRoute(Request $request)
    {
        if (Admin::user()->checkViaRoute($request)) {
            return true;
        }

        throw UnauthorizedException::forRoutePath($request->path());
    }
}
