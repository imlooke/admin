<?php

namespace Imlooke\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UserResource
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['menus'] = $this->getMenus();

        return $data;
    }
}
