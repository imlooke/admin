<?php

namespace Imlooke\Admin\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'route_path', 'route_name', 'route_method',
    ];

    /**
     * Route methods.
     *
     * @var array
     */
    public static $routeMethods = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.database.permissions_table', parent::getTable());
    }

    /**
     * A permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.roles_model'),
            config('admin.database.role_permission_table'),
            'permission_id',
            'role_id'
        );
    }

    /**
     * A permission belongs to many users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.users_model'),
            config('admin.database.user_permission_table'),
            'permission_id',
            'user_id'
        );
    }
}
