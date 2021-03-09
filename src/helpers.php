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
