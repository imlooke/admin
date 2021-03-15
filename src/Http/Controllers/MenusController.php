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
        $model = new Menu;

        if ($hiddenId = request()->input('hidden_id', null)) {
            $model->withQuery(function ($query) use ($hiddenId) {
                return $query->where('id', '<>', $hiddenId);
            });
        }

        $response = $model->getTree();
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
        if (Menu::where('parent_id', $id)->exists()) {
            return response()->error(trans('admin::lang.menus.cannot_delete'));
        }

        Menu::destroy($id);

        return response()->success(trans('admin::lang.success.destroy'));
    }

    public function order()
    {
        $orders = request()->input('orders', []);

        foreach ($orders as $key => $value) {
            Menu::where('id', $key)->update(['order' => $value]);
        }

        return response()->success(trans('admin::lang.menus.update_order'));
    }
}
