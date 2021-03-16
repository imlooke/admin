<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Http\Requests\SettingsRequest;
use Imlooke\Admin\Models\Setting;

/**
 * SettingsController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
// TODO:files upload
class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('order', 'ASC')->get()->groupBy('group');

        $groups = Setting::select('group')->distinct()->get();

        return response()->json(compact('settings', 'groups'));
    }

    public function store(SettingsRequest $request)
    {
        $data = $request->only([
            'name', 'key', 'details', 'type', 'group',
        ]);

        Setting::create($data);

        return response()->success(__('admin::lang.success.store'));
    }

    public function update(SettingsRequest $request, $id)
    {
        $data = $request->input('data');

        foreach ($data as $value) {
            $setting = Setting::findOrFail($value['id']);
            $setting->update(['value' => $value['value']]);
        }

        return response()->success(__('admin::lang.success.update'));
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return response()->success(__('admin::lang.success.destroy'));
    }

    public function moveUp($id)
    {
        $setting = Setting::findOrFail($id);
        $currentOrder = $setting->order;
        $message = __('admin::lang.settings.already_at_top');

        $previousSetting = Setting::where([
            ['order', '<', $currentOrder],
            ['group', '=', $setting->group]
        ])->orderBy('order', 'DESC')->first();

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $currentOrder;
            $previousSetting->save();

            $message = __('admin::lang.settings.moved_order_up', ['name' => $setting->name]);
        }

        return response()->success($message);
    }

    public function moveDown($id)
    {
        $setting = Setting::findOrFail($id);
        $currentOrder = $setting->order;
        $message = __('admin::lang.settings.already_at_bottom');

        $nextSetting = Setting::where([
            ['order', '>', $currentOrder],
            ['group', '=', $setting->group]
        ])->orderBy('order', 'ASC')->first();

        if (isset($nextSetting->order)) {
            $setting->order = $nextSetting->order;
            $setting->save();
            $nextSetting->order = $currentOrder;
            $nextSetting->save();

            $message = __('admin::lang.settings.moved_order_down', ['name' => $setting->name]);
        }

        return response()->success($message);
    }
}
