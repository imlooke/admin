<?php

namespace Imlooke\Admin\Traits;

use Illuminate\Support\Arr;

/**
 * CategoryPath
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
trait CategoryPath
{
    /**
     * The parent column name.
     *
     * @var string
     */
    protected $parentColumn = 'parent_id';

    /**
     * The path column name.
     *
     * @var string
     */
    protected $pathColumn = 'path';

    /**
     * The path_array attribute.
     *
     * @var array
     */
    protected $pathArray = null;

    /**
     * Boot trait.
     *
     * @return void
     */
    public static function bootCategoryPath()
    {
        static::created(function ($model) {
            $model->createPath();
        });

        static::updating(function ($model) {
            $model->updatePath();
        });
    }

    /**
     * Create path.
     *
     * @return this
     */
    public function createPath()
    {
        $id = $this->getKey();
        $parent = $this->{$this->parentColumn};
        $newPath = '0-' . $id;

        if ($parent !== 0) {
            $parentPath = $this->where($this->getKeyName(), $parent)
                ->value($this->pathColumn);
            $newPath = "$parentPath-$id";
        }

        $this->savePath($newPath);
        $this->save();

        return $this;
    }

    /**
     * Update path.
     *
     * @return this
     */
    public function updatePath()
    {
        // must update path before data updated, otherwise
        // can not find the former path value.
        $id = $this->getKey();
        $parent = $this->{$this->parentColumn};
        $oldPath = $this->{$this->pathColumn};
        $newPath = '0-' . $id;

        if ($parent !== 0) {
            $parentPath = $this->where($this->getKeyName(), $parent)
                ->value($this->pathColumn);
            $newPath = "$parentPath-$id";
        }

        $this->savePath($newPath);

        // if current path was changed, update
        // this category children path
        if ($newPath != $oldPath) {
            $children = $this->select($this->getKeyName(), $this->pathColumn)
                ->where($this->pathColumn, 'LIKE', $oldPath . "-%")
                ->get();

            foreach ($children as $child) {
                $childPath = str_replace("$oldPath-", "$newPath-", $child[$this->pathColumn]);
                $this->where($this->getKeyName(), $child[$this->getKeyName()])
                    ->update([
                        $this->pathColumn => $childPath
                    ]);
            }
        }

        return $this;
    }

    /**
     * Get path_array attribute.
     *
     * @return array
     */
    public function getPathArrayAttribute()
    {
        return $this->getPathArray();
    }

    /**
     * Get path_array_no_self attribute.
     *
     * @return array
     */
    public function getPathArrayNoSelfAttribute()
    {
        $pathArray = $this->getPathArray();

        if (count($pathArray) === 1) {
            return $pathArray;
        }

        Arr::pull($pathArray, count($pathArray) - 1);

        return $pathArray;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function getPathArray()
    {
        if (is_null($this->pathArray)) {
            $parent = $this->{$this->parentColumn};
            $path = $this->{$this->pathColumn};

            $this->pathArray = [0];

            if ($parent !== 0) {
                $result = explode('-', $path);
                Arr::pull($result, 0);

                $this->pathArray = array_values(
                    array_map(function ($v) {
                        return (int) $v;
                    }, $result)
                );
            }
        }

        return $this->pathArray;
    }

    /**
     * Save path.
     *
     * @param  string $value
     * @return void
     */
    protected function savePath($value)
    {
        $this->{$this->pathColumn} = $value;
    }
}
