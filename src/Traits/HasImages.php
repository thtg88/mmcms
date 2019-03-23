<?php

namespace SdSomersetDesign\CastleCombe\Traits;

use SdSomersetDesign\CastleCombe\Models\ImageCategory;

trait HasImages
{
    /**
     * Determine if the model instance has images
     *
     * @return bool
     */
    public function images()
    {
        return $this->morphMany(
            'SdSomersetDesign\CastleCombe\Models\Image',
            'target',
            'target_table'
        );
    }

    /**
     * Determine if the model instance has children
     *
     * @return bool
     */
    public function getImageCategoriesAttribute()
    {
        return ImageCategory::where('target_table', $this->getTable())->get();
    }
}
