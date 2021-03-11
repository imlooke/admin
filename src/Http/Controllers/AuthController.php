<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Auth\AuthenticatesUsers;

/**
 * AuthController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class AuthController extends Controller
{
    use AuthenticatesUsers;
}
