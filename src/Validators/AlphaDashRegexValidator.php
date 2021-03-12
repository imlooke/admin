<?php

namespace Imlooke\Admin\Validators;

/**
 * AlphaDashRegexValidator
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class AlphaDashRegexValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return preg_match('/^[A-Za-z0-9\-\_]+$/', $value);
    }
}
