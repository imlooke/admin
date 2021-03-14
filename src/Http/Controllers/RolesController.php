<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Models\Role;
use Imlooke\Admin\Http\Requests\RolesRequest;
use Imlooke\Admin\Traits\AdminApiResource;

/**
 * RolesController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class RolesController extends Controller
{
    use AdminApiResource;

    public function index()
    {
        $response = $this->fillter(Role::class);

        return response()->json($response);
    }

    public function store(RolesRequest $request)
    {
        $data = $request->only(['name', 'slug']);

        $role = Role::create($data);
        $role->permissions()->attach(
            $request->input('permissions')
        );
        $role->menus()->attach(
            $request->input('menus')
        );

        return response()->success(trans('admin::lang.success.store'));
    }

    public function show($id)
    {
        $response = Role::with(['permissions:id', 'menus:id'])->findOrFail($id);

        return response()->json($response);
    }

    public function update(RolesRequest $request, $id)
    {
        $data = $request->only(['name', 'slug']);

        $role = Role::findOrFail($id);
        $role->update($data);

        return response()->success(trans('admin::lang.success.update'));
    }

    public function destroy($id)
    {
        $this->multiDestroy(Role::class);

        return response()->success(trans('admin::lang.success.destroy'));
    }
}
