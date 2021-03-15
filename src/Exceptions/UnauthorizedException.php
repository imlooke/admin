<?php

namespace Imlooke\Admin\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * UnauthorizedException
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UnauthorizedException extends Exception
{
    /**
     * @param string $message
     */
    public function __construct($message, $statusCode = 403)
    {
        parent::__construct($message, $statusCode);
    }

    /**
     * Exception for not logged in.
     *
     * @return self
     */
    public static function notLoggedIn(): self
    {
        $message = trans('admin::lang.auth.unauthenticated');
        $exception = new static($message, 401);

        return $exception;
    }

    /**
     * Exception for permissions.
     *
     * @param  array $permissions
     * @return self
     */
    public static function forPermissions(array $permissions): self
    {
        $permStr = implode(', ', $permissions);
        $message = trans('admin::lang.permissions.no_permissions') . $permStr;
        $exception = new static($message);

        return $exception;
    }

    /**
     * Exception for roles.
     *
     * @param  array $roles
     * @return self
     */
    public static function forRoles(array $roles): self
    {
        $permStr = implode(', ', $roles);
        $message = trans('admin::lang.permissions.no_roles') . $permStr;
        $exception = new static($message);

        return $exception;
    }

    /**
     * Exception for route path.
     *
     * @param  string $path
     * @return self
     */
    public static function forRoutePath(string $path): self
    {
        $message = trans('admin::lang.permissions.access_denied');
        $exception = new static($message);

        return $exception;
    }

    /**
     * Render exception.
     *
     * @return JsonResponse
     */
    public function render()
    {
        return new JsonResponse([
            'message' => $this->message
        ], $this->code);
    }
}
