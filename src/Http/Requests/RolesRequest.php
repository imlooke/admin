<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * RolesRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class RolesRequest extends FormRequest
{
    public function rules()
    {
        $rolesTable = config('admin.database.roles_table');
        $permissionsTable = config('admin.database.permissions_table');
        $menusTable = config('admin.database.menus_table');

        $rules = [
            'name'          => "required|string|unique:$rolesTable,name",
            'slug'          => "required|string|alpha_dot_regex|unique:$rolesTable,slug",
            'permissions'   => "nullable|array",
            'permissions.*' => "nullable|numeric|exists:$permissionsTable,id",
            'menus'         => "nullable|array",
            'menus.*'       => "nullable|numeric|exists:$menusTable,id",
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = "required|string|unique:$rolesTable,name," . $this->role;
            $rules['slug'] = "required|string|alpha_dot_regex|unique:$rolesTable,slug," . $this->role;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'slug'        => trans('admin::validation.attributes.slug'),
            'permissions' => trans('admin::validation.attributes.permissions'),
            'menus'       => trans('admin::validation.attributes.menus'),
        ];
    }
}
