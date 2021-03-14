<?php

namespace Imlooke\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Imlooke\Admin\Facades\Admin;

/**
 * Permission
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Permission
{
    public function handle(Request $request, Closure $next, ...$args)
    {
        dd(Admin::user()->toArray());
    }
}
