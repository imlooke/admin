<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Imlooke\Admin\Auth\Models\Permission;

/**
 * PermissionsRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class PermissionsRequest extends FormRequest
{
    public function rules()
    {
        $table = config('admin.database.permissions_table');

        $rules = [
            'name'         => "required|string|unique:$table,name",
            'slug'         => "required|string|alpha_dot_regex|unique:$table,slug",
            'route_path'   => "nullable|route_path_regex",
            'route_method' => [
                "nullable", "array",
                function ($attribute, $value, $fail) {
                    $routeMethods = collect(Permission::$routeMethods);
                    foreach ($value as $str) {
                        $str = Str::upper($str);
                        if (!$routeMethods->contains($str)) {
                            $fail(trans('admin::lang.permissions.invalid_route_method'));
                        }
                    }
                },
            ],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = "required|string|unique:$table,name," . $this->role;
            $rules['slug'] = "required|string|alpha_dash_regex|unique:$table,slug," . $this->role;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'slug'         => trans('admin::validation.attributes.slug'),
            'route_path'   => trans('admin::validation.attributes.route_path'),
            'route_method' => trans('admin::validation.attributes.route_method'),
        ];
    }
}
