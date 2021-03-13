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
        $table = config('admin.database.roles_table');

        $rules = [
            'name' => "required|string|unique:$table,name",
            'slug' => "required|string|alpha_dot_regex|unique:$table,slug",
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = "required|string|unique:$table,name," . $this->role;
            $rules['slug'] = "required|string|alpha_dot_regex|unique:$table,slug," . $this->role;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'slug' => trans('admin::validation.attributes.slug'),
        ];
    }
}
