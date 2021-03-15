<?php

namespace Imlooke\Admin\Auth;

use Illuminate\Support\Collection;

/**
 * HasPermissions
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
trait HasPermissions
{
    /**
     * Get user direct permissions.
     *
     * @return Collection
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * Get permissions from roles.
     *
     * @return Collection
     */
    public function getPermissionsViaRoles(): Collection
    {
        return $this->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten();
    }

    /**
     * Get all permissions.
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return $this->permissions->merge(
            $this->getPermissionsViaRoles()
        );
    }

    /**
     * Check permission via slug.
     *
     * @param  string $slug
     * @return boolean
     */
    public function hasPermissionTo(string $slug): bool
    {
        if ($this->isAdministrator()) {
            return true;
        }

        return $this->getAllPermissions()->contains('slug', $slug);
    }

    /**
     * Check role via slug.
     *
     * @param  string $slug
     * @return boolean
     */
    public function hasRole(string $slug): bool
    {
        // if user has administrator role, pass
        if ($this->roles->contains('slug', 'administrator')) {
            return true;
        }

        return $this->roles->contains('slug', $slug);
    }

    /**
     * User is administrator.
     *
     * @return boolean
     */
    public function isAdministrator(): bool
    {
        return $this->hasRole('administrator');
    }

    /**
     * Check permission via slug.
     *
     * @param  string $slug
     * @return boolean
     */
    public function check(string $slug): bool
    {
        return $this->hasPermissionTo($slug);
    }

    /**
     * Check permission via route path.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    public function checkViaRoute($request): bool
    {
        if ($this->isAdministrator()) {
            return true;
        }

        return $this->getAllPermissions()->contains(function ($permission) use ($request) {

            $methods = collect($permission->route_method);
            $paths = explode("\n", $permission->route_path);

            foreach ($paths as $path) {
                $path = trim(trim($path, '/'));
                if (!$request->is($path)) {
                    continue;
                }

                if ($methods->isEmpty()) {
                    return true;
                }
                if ($methods->contains($request->method())) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * User can do ability.
     *
     * @param  string $ability
     * @param  array $arguments
     * @return boolean
     */
    public function can($ability, $arguments = []): bool
    {
        return $this->check($ability);
    }

    /**
     * User cannot do ability.
     *
     * @param  string $ability
     * @param  array $arguments
     * @return boolean
     */
    public function cannot($ability, $arguments = []): bool
    {
        return !$this->can($ability, $arguments = []);
    }
}
