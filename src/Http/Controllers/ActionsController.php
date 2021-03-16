<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

/**
 * ActionsController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class ActionsController extends Controller
{
    public function clearCache()
    {
        Cache::flush();

        return response()->success(trans('admin::lang.success.clear_cache'));
    }
}
