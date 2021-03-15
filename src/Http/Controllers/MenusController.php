<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Models\Menu;
use Imlooke\Admin\Http\Requests\MenusRequest;
use Imlooke\Admin\Traits\AdminApiResource;

/**
 * MenusController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class MenusController extends Controller
{
    use AdminApiResource;

    public function index()
    {
        $response = $this->fillter(Menu::class);

        return response()->json($response);
    }

    public function store(MenusRequest $request)
    {
        $data = $request->only([
            'parent_id', 'type', 'order', 'name', 'route_path', 'icon', 'description',
        ]);

        Menu::create($data);

        return response()->success(trans('admin::lang.success.store'));
    }

    public function show($id)
    {
        $response = Menu::findOrFail($id);

        return response()->json($response);
    }

    public function update(MenusRequest $request, $id)
    {
        $data = $request->only([
            'parent_id', 'type', 'order', 'name', 'route_path', 'icon', 'description',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($data);

        return response()->success(trans('admin::lang.success.update'));
    }

    public function destroy($id)
    {
        $this->multiDestroy(Menu::class);

        return response()->success(trans('admin::lang.success.destroy'));
    }
}
