<?php

namespace Imlooke\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Admin
 *
 * @method static void routes()
 *
 * @see Imlooke\Admin\Admin
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class Admin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'imlooke.admin';
    }
}
