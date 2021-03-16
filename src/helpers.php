<?php

if (!function_exists('admin_path')) {
    /**
     * Get admin path.
     *
     * @param  string $path
     * @return string
     */
    function admin_path($path = '')
    {
        return config('admin.directory') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('setting')) {
    /**
     * Get setting from database.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return \Imlooke\Admin\Facades\Admin::setting($key, $default);
    }
}
