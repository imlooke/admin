<?php

namespace Imlooke\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * IndexController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class IndexController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin::index');
    }
}
