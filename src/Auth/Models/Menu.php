<?php

namespace Imlooke\Admin\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Imlooke\Admin\Traits\CategoryPath;

/**
 * Menu
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Menu extends Model
{
    use CategoryPath;

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
        'icon',
        'description',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'path_array',
        'path_array_no_self',
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
        });
    }

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
        return $this->belongsToMany(
            config('admin.database.roles_model'),
            config('admin.database.role_menu_table'),
            'menu_id',
            'role_id'
        );
    }
}
