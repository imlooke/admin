<?php

namespace Imlooke\Admin\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * AdminValidator
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class AdminValidator
{
    protected $rules = [
        'AlphaDash',
        'AlphaDot',
        'PhoneNumber',
        'RoutePath',
    ];

    protected $validators = [
        //
    ];

    public function register()
    {
        // register from roles
        foreach ($this->rules as $key => $rule) {
            Validator::extend(
                $ruleName = Str::snake($rule) . "_regex",
                function ($attribute, $value, $parameters, $validator) use ($rule, $ruleName) {
                    // if this rule not passed, add message to validator
                    // then return false, otherwise return true
                    if (!$this->{"validate" . $rule}(...func_get_args())) {
                        $validator->setCustomMessages([
                            $ruleName => trans("admin::validation.$ruleName")
                        ]);
                        return false;
                    }

                    // setAttributeNames
                    return true;
                }
            );
        }

        // register from validators
        foreach ($this->validators as $rule => $validator) {
            Validator::extend($rule, "{$validator}@validate");
        }
    }

    public function validateAlphaDash($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^[A-Za-z0-9\-\_]+$/', $value);
    }

    public function validateAlphaDot($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^[A-Za-z0-9\.]+$/', $value);
    }

    public function validatePhoneNumber($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^((\+|00)86)?1([358][0-9]|4[579]|6[67]|7[0135678]|9[189])[0-9]{8}$/', $value);
    }

    public function validateRoutePath($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^[A-Za-z0-9\-\_\/\.\\{}?]+$/', $value);
    }
}
