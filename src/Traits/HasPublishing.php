<?php

namespace SdSomersetDesign\CastleCombe\Traits;

trait HasPublishing
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootHasPublishing()
    {
        static::addGlobalScope(new PublishingScope);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function publish()
    {
        $this->{$this->getPublishedAtColumn()} = $this->freshTimestampString();

        $result = $this->save();

        return $result;
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function unpublish()
    {
        $this->{$this->getPublishedAtColumn()} = null;

        $result = $this->save();

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function published()
    {
        return ! is_null($this->{$this->getPublishedAtColumn()});
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getPublishedAtColumn()
    {
        return defined('static::PUBLISHED_AT') ? static::PUBLISHED_AT : 'published_at';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedPublishedAtColumn()
    {
        return $this->qualifyColumn($this->getPublishedAtColumn());
    }
}
