<?php

namespace Imlooke\Admin\Auth\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\URL;

/**
 * Administrator
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Administrator extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'avatar', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_login_at' => 'datetime',
        'recently_login_at' => 'datetime',
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
            $model->permissions()->detach();
        });
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.database.users_table', parent::getTable());
    }

    /**
     * Get avatar attribute.
     *
     * @param  string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (URL::isValidUrl($value)) {
            return $value;
        }

        // TODO:
        $default = '';

        return $default;
    }

    /**
     * A admin has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.roles_model'),
            config('admin.database.user_role_table'),
            'user_id',
            'role_id'
        );
    }

    /**
     * A admin has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('admin.database.permissions_model'),
            config('admin.database.user_permission_table'),
            'user_id',
            'permission_id'
        );
    }
}
