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
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.table_names.roles', parent::getTable());
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.table_names.roles');

        $relatedModel = config('admin.table_names.permissions');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'permission_id');
    }

    /**
     * A role belongs to many admins.
     *
     * @return BelongsToMany
     */
    public function admins(): BelongsToMany
    {
        $pivotTable = config('admin.table_names.admins');

        $relatedModel = config('admin.table_names.roles');

        return $this->belongsToMany($relatedModel, $pivotTable, 'admin_id', 'role_id');
    }

    /**
     * A role belongs to many menus.
     *
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        $pivotTable = config('admin.table_names.roles');

        $relatedModel = config('admin.table_names.menus');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'menu_id');
    }
}
