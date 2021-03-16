<?php

namespace Imlooke\Admin\Traits;

/**
 * AdminApiResource
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
trait AdminApiResource
{
    /**
     * Add fillter method to controller.
     *
     * @param  string|Illuminate\Database\Eloquent\Builder $model
     * @return collection
     */
    protected function fillter($model)
    {
        if (is_string($model)) {
            $model = new $model;
        }

        $key = request()->input('key');
        $search = request()->input('search');
        $orderBy = request()->input('order_by', 'created_at');
        $sortOrder = request()->input('sort_order', 'desc');

        if (!is_null($key) && !is_null($search)) {
            $model = $model->where($key, 'LIKE', "%$search%");
        }

        $model = $model->orderBy($orderBy, $sortOrder);

        if (request()->has('per_page')) {
            $perPage = (int) request()->input('per_page', 15);
            return $model->paginate($perPage);
        }

        return $model->get();
    }

    /**
     * Add mutil destroy method to controller.
     *
     * @param  string $model
     * @return integer
     */
    protected function multiDestroy($model)
    {
        $id = 0;
        $parameters = request()->route()->parameters();

        if (is_array($parameters) && count($parameters)) {
            $id = end($parameters);
        }

        if (empty($id)) {
            $ids = request()->input('ids', []);
        } else {
            $ids[] = $id;
        }

        return $model::destroy($ids);
    }

    /**
     * Add toggle data method to controller.
     *
     * @param  string $model
     * @return void
     */
    protected function toggleData($model)
    {
        $data = request()->input('data', []);

        if (request()->has(['id', 'key', 'value'])) {
            $data[] = request()->only(['id', 'key', 'value']);
        }

        foreach ($data as $value) {
            $model::findOrFail($value['id'])->update([
                $value['key'] => $value['value']
            ]);
        }

        return true;
    }
}
