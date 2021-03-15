<?php

namespace Imlooke\Admin\Auth;

use Imlooke\Admin\Models\Menu;

/**
 * HasMenus
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
trait HasMenus
{
    /**
     * Get menus.
     *
     * @return array
     */
    public function getMenus()
    {
        if ($this->isAdministrator()) {
            return (new Menu)->getTree();
        }

        $ids = $this->roles()->with('menus')->get()
            ->pluck('menus')->flatten()
            ->pluck('id')->unique()->toArray();

        return (new Menu)->withQuery(function ($query) use ($ids) {
            return $query->whereIn('id', $ids);
        })->getTree();
    }
}
