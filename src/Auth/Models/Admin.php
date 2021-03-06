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
 * Admin
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'avatar', 'email', 'phone', 'password',
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
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.table_names.admins', parent::getTable());
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
        $pivotTable = config('admin.table_names.admins');

        $relatedModel = config('admin.table_names.roles');

        return $this->belongsToMany($relatedModel, $pivotTable, 'admin_id', 'role_id');
    }

    /**
     * A admin has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.table_names.admins');

        $relatedModel = config('admin.table_names.permissions');

        return $this->belongsToMany($relatedModel, $pivotTable, 'admin_id', 'permission_id');
    }
}
