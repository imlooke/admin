<?php

namespace Imlooke\Admin\Validators;

/**
 * PhoneNumberValidator
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class PhoneNumberValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^((\+|00)86)?1([358][0-9]|4[579]|6[67]|7[0135678]|9[189])[0-9]{8}$/', $value);
    }
}
