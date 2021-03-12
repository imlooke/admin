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
            'slug' => "required|string|alpha_dash_regex|unique:$table,slug",
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = "required|string|unique:$table,name," . $this->role;
            $rules['slug'] = "required|string|alpha_dash_regex|unique:$table,slug," . $this->role;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'slug.alpha_dash_regex' => '标识只支持英文、数字、横杠和下划线。',
        ];
    }
}
