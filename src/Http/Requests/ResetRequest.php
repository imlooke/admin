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
                        $fail(trans('admin::lang.auth.password'));
                    }
                },
            ],
            'new_password' => 'required|string|min:6|confirmed|alpha_dash_regex',
        ];
    }

    public function attributes()
    {
        return [
            'new_password'              => trans('admin::validation.attributes.new_password'),
            'new_password_confirmation' => trans('admin::validation.attributes.new_password_confirmation'),
        ];
    }
}
