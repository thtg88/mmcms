<?php

namespace SdSomersetDesign\CastleCombe\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PublishingScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Publish', 'Unpublish', 'WithPublished', 'WithoutPublished', 'OnlyPublished'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // $builder->whereNotNull($model->getQualifiedPublishedAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "published at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getPublishedAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedPublishedAtColumn();
        }

        return $builder->getModel()->getPublishedAtColumn();
    }

    /**
     * Add the publish extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addPublish(Builder $builder)
    {
        $builder->macro('publish', function (Builder $builder) {
            $builder->withPublished();
            $column = $this->getPublishedAtColumn($builder);

            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }

    /**
     * Add the unpublish extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addUnpublish(Builder $builder)
    {
        $builder->macro('unpublish', function (Builder $builder) {
            $builder->withPublished();
            $column = $this->getPublishedAtColumn($builder);

            return $builder->update([
                $column => null
            ]);
        });
    }

    /**
     * Add the with-published extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithPublished(Builder $builder)
    {
        $builder->macro('withPublished', function (Builder $builder, $withPublished = true) {
            if (! $withPublished) {
                return $builder->withoutPublished();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-published extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutPublished(Builder $builder)
    {
        $builder->macro('withoutPublished', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->whereNull(
                $model->getQualifiedPublishedAtColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-published extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyPublished(Builder $builder)
    {
        $builder->macro('onlyPublished', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->whereNotNull(
                $model->getQualifiedPublishedAtColumn()
            );

            return $builder;
        });
    }
}
