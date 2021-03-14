<?php

namespace Imlooke\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * MenusRequest
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class MenusRequest extends FormRequest
{
    public function rules()
    {
        return [
            'parent_id'   => 'required|numeric',
            'type'        => 'required|numeric|in:1,2',
            'status'      => 'required|boolean',
            'order'       => 'required|numeric|between:0,99999',
            'name'        => 'required|string|max:64',
            'route_path'  => 'required|string|route_path_regex',
            'icon'        => 'nullable|string|max:64',
            'description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'parent_id'   => trans('admin::validation.attributes.parent_id'),
            'type'        => trans('admin::validation.attributes.type'),
            'status'      => trans('admin::validation.attributes.status'),
            'order'       => trans('admin::validation.attributes.order'),
            'route_path'  => trans('admin::validation.attributes.route_path'),
            'icon'        => trans('admin::validation.attributes.icon'),
        ];
    }
}
