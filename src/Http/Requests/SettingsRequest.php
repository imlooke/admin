<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Imlooke\Admin\Models\Setting;

/**
 * SettingsRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class SettingsRequest extends FormRequest
{
    public function rules()
    {
        $table = config('admin.database.settings_table');

        $types = implode(',', Setting::$types);

        if ($this->isMethod('post')) {
            return [
                'name'    => 'required|string',
                'key'     => "required|string|alpha_dash_regex|unique:$table,key",
                'details' => 'nullable|json',
                'type'    => "required|string|in:$types",
                'group'   => 'required|string',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'data'         => 'required|array',
                'data.*.id'    => 'required|numeric',
                'data.*.value' => 'required|string',
            ];
        }
    }

    public function attributes()
    {
        return [
            'key'     => trans('admin::validation.attributes.key'),
            'details' => trans('admin::validation.attributes.details'),
            'type'    => trans('admin::validation.attributes.type'),
            'group'   => trans('admin::validation.attributes.group'),
        ];
    }
}
