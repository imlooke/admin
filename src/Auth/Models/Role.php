<?php

namespace Imlooke\Admin\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
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

            $model->permissions()->detach();
            $model->users()->detach();
            $model->menus()->detach();
        });
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.database.roles_table', parent::getTable());
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.permissions_model'),
            config('admin.database.role_permission_table'),
            'role_id',
            'permission_id'
        );
    }

    /**
     * A role belongs to many users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.users_model'),
            config('admin.database.user_role_table'),
            'role_id',
            'user_id'
        );
    }

    /**
     * A role belongs to many menus.
     *
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.menus_model'),
            config('admin.database.role_menu_table'),
            'role_id',
            'menu_id'
        );
    }
}
