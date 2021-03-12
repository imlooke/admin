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
            'name' => 'nullable|string',
            'avatar' => 'nullable|string',
            'email' => 'nullable|string|max:64|email',
            'phone' => 'nullable|string|max:32|phone_number',
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => '用户名已被占用，请重新填写。',
            'username.alpha_dash_regex' => '用户名只支持英文、数字、横杠和下划线。',
            'username.between' => '用户名必须介于 3 - 25 个字符之间。',
            'username.required' => '用户名不能为空。',
            'phone.phone_number' => '手机号格式不正确，请重新填写。',
        ];
    }
}
