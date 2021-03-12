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
     * @param  String|Illuminate\Database\Eloquent\Builder $model
     * @return Collection
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
            $model->where($key, 'LIKE', "%$search%");
        }

        $model->orderBy($orderBy, $sortOrder);

        if (request()->has('per_page')) {
            $perPage = (int) request()->input('per_page', 15);
            return $model->paginate($perPage);
        }

        return $model->get();
    }

    /**
     * add mutil destroy method to controller.
     *
     * @param  String $model
     * @return Integer
     */
    protected function multiDestroy($model, $id = 0)
    {
        if (empty($id)) {
            $ids = request()->input('ids', []);
        } else {
            $ids[] = $id;
        }

        return $model::destroy($ids);
    }
}
