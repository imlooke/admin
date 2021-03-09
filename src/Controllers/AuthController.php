<?php

namespace Imlooke\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * AuthController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class AuthController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('admin::index');
    }
}
