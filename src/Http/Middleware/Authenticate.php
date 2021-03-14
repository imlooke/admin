<?php

namespace Imlooke\Admin\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;

/**
 * Authenticate
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Authenticate implements AuthenticatesRequests
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $guard = config('admin.auth.guard', 'admin');

        if ($this->auth->guard($guard)->check()) {
            $this->auth->shouldUse($guard);
            return $next($request);
        }

        throw new AuthenticationException(trans('admin::lang.auth.unauthenticated'), [$guard]);
    }
}
