<?php

namespace Imlooke\Admin\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Menu
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'path',
        'type',
        'is_protected',
        'status',
        'order',
        'name',
        'route_path',
        'route_name',
        'icon',
        'description',
        'app_group',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.database.menus_table', parent::getTable());
    }

    /**
     * A Menu belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.roles_table');

        $relatedModel = config('admin.database.menus_table');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'menu_id');
    }
}
