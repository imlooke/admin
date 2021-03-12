<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * IndexController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class IndexController extends Controller
{
    public function index()
    {
        return view('admin::index');
    }
}
