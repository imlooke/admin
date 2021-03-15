<?php

namespace Imlooke\Admin\Traits;

/**
 * CategoryPath
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
trait Tree
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
     * The order column name.
     *
     * @var string
     */
    protected $orderColumn = 'order';

    /**
     * Query callback.
     *
     * @var \Closure
     */
    protected $queryCallback;

    /**
     * Set query callback to model.
     *
     * @param \Closure|null $query
     * @return $this
     */
    public function withQuery(\Closure $query = null)
    {
        $this->queryCallback = $query;

        return $this;
    }

    /**
     * Get tree.
     *
     * @return array
     */
    public function getTree(): array
    {
        return $this->buildNestedArray();
    }

    /**
     * Build nested array.
     *
     * @param  array $nodes
     * @param  integer $parent
     * @return array
     */
    protected function buildNestedArray(array $nodes = [], $parent = 0): array
    {
        $results = [];

        if (empty($nodes)) {
            $nodes = $this->allNodes();
        }

        foreach ($nodes as $node) {
            if ($node[$this->parentColumn] == $parent) {
                $children = $this->buildNestedArray($nodes, $node[$this->getKeyName()]);

                if ($children) {
                    $node['children'] = $children;
                }

                $results[] = $node;
            }
        }

        return $results;
    }

    /**
     * Get all nodes.
     *
     * @return array
     */
    protected function allNodes(): array
    {
        $self = new static();

        if ($this->queryCallback instanceof \Closure) {
            $self = call_user_func($this->queryCallback, $self);
        }

        return $self->orderBy($this->orderColumn)->get()->toArray();
    }
}
