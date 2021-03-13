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
        'name', 'slug', 'route_path', 'route_method',
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
     * Bootstrap the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // delete pivot records
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            $model->roles()->detach();
            $model->users()->detach();
        });
    }

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

    /**
     * Set route_method attribute.
     *
     * @param  array $value
     * @return string
     */
    public function setRouteMethodAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['route_method'] = implode(',', $value);
        }
    }

    /**
     * Get route_method attribute.
     *
     * @param  string $value
     * @return array
     */
    public function getRouteMethodAttribute(string $value)
    {
        return explode(',', $value);
    }
}
