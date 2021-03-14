<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Models\Permission;
use Imlooke\Admin\Http\Requests\PermissionsRequest;
use Imlooke\Admin\Traits\AdminApiResource;

/**
 * PermissionsController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class PermissionsController extends Controller
{
    use AdminApiResource;

    public function index()
    {
        $response = $this->fillter(Permission::class);

        return response()->json($response);
    }

    public function store(PermissionsRequest $request)
    {
        $data = $request->only([
            'name', 'slug', 'route_path', 'route_method',
        ]);

        Permission::create($data);

        return response()->success(trans('admin::lang.success.store'));
    }

    public function show($id)
    {
        $response = Permission::findOrFail($id);

        return response()->json($response);
    }

    public function update(PermissionsRequest $request, $id)
    {
        $data = $request->only([
            'name', 'slug', 'route_path', 'route_method',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update($data);

        return response()->success(trans('admin::lang.success.update'));
    }

    public function destroy($id)
    {
        $this->multiDestroy(Permission::class);

        return response()->success(trans('admin::lang.success.destroy'));
    }
}
