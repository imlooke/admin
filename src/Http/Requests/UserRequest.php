<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * UserRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UserRequest extends FormRequest
{
    public function rules()
    {
        $table = config('admin.database.users_table');

        return [
            'username' => "required|string|between:3,25|alpha_dash_regex|unique:$table,username," . Auth::id(),
            'name'     => 'nullable|string',
            'avatar'   => 'nullable|string',
            'email'    => 'nullable|string|max:64|email',
            'phone'    => 'nullable|string|max:32|phone_number_regex',
        ];
    }

    public function attributes()
    {
        return [
            'avatar' => trans('admin::validation.attributes.avatar'),
        ];
    }
}
