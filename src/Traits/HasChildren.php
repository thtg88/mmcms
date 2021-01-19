<?php

namespace Thtg88\MmCms\Traits;

trait HasChildren
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootHasChildren()
    {
        static::addGlobalScope(new ChildrenScope());
    }

    /**
     * Determine if the model instance has a parent.
     *
     * @return bool
     */
    public function parent()
    {
        return $this->belongsTo(get_class($this), $this->getParentIdColumn(), 'id')->withChildren();
    }

    /**
     * Determine if the model instance has children.
     *
     * @return bool
     */
    public function children()
    {
        return $this->hasMany(get_class($this), $this->getParentIdColumn(), 'id')->withChildren();
    }

    /**
     * Get the name of the "parent_id" column.
     *
     * @return string
     */
    public function getParentIdColumn()
    {
        return defined('static::PARENT_ID') ? static::PARENT_ID : 'parent_id';
    }

    /**
     * Get the fully qualified "parent_id" column.
     *
     * @return string
     */
    public function getQualifiedParentIdColumn()
    {
        return $this->getTable().'.'.$this->getParentIdColumn();
    }
}
