<?php

namespace Thtg88\MmCms\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ChildrenScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithChildren', 'WithoutChildren', 'OnlyChildren'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedParentIdColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "parent_id" column for the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getParentIdColumn(Builder $builder)
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedParentIdColumn();
        }

        return $builder->getModel()->getParentIdColumn();
    }

    /**
     * Add the with-children extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithChildren(Builder $builder)
    {
        $builder->macro('withChildren', function (Builder $builder, $withChildren = true) {
            if (! $withChildren) {
                return $builder->withoutChildren();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-children extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutChildren(Builder $builder)
    {
        $builder->macro('withoutChildren', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedParentIdColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-children extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyChildren(Builder $builder)
    {
        $builder->macro('onlyChildren', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedParentIdColumn()
            );

            return $builder;
        });
    }
}
