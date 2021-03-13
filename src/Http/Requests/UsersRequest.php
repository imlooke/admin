<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UsersRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UsersRequest extends FormRequest
{
    public function rules()
    {
        $table = config('admin.database.users_table');

        $roles = [
            'username' => "required|string|between:3,25|alpha_dash_regex|unique:$table,username",
            'name'     => 'nullable|string',
            'avatar'   => 'nullable|string',
            'email'    => 'nullable|string|max:64|email',
            'phone'    => 'nullable|string|max:32|phone_number_regex',
            'password' => 'required|string|min:6|alpha_dash_regex',
            'roles'    => 'nullable|array'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $roles['username'] = "required|string|between:3,25|alpha_dash_regex|unique:$table,username," . $this->user;
            $roles['password'] = 'nullable|string|min:6|alpha_dash_regex';
        }

        return $roles;
    }

    public function attributes()
    {
        return [
            'avatar' => trans('admin::validation.attributes.avatar'),
        ];
    }
}
