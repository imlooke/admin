<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * ResetRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class ResetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => [
                'required', 'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail('当前密码错误，请重新输入。');
                    }
                },
            ],
            'new_password' => 'required|string|min:6|confirmed|alpha_dash_regex',
        ];
    }

    public function messages()
    {
        return [
            'new_password.alpha_dash_regex' => '密码只支持英文、数字、横杠和下划线。',
        ];
    }
}
