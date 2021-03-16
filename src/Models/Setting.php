<?php

namespace Imlooke\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Setting
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Setting extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Undocumented variable
     *
     * @var array
     */
    public static $types = [
        'text',
        'text_area',
        'file',
        'image',
    ];

    /**
     * Bootstrap the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // forget cache
        static::saving(function ($model) {
            $key = "settings::{$model->key}";
            cache()->has($key) && cache()->forget($key);
        });
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('admin.database.settings_table', parent::getTable());
    }
}
