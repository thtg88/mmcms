<?php

namespace Thtg88\MmCms\Traits;

use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Models\ImageCategory;

trait HasImages
{
    /**
     * Determine if the model instance has images.
     *
     * @return bool
     */
    public function images()
    {
        return $this->morphMany(
            Config::get('mmcms.models.namespace').'Image',
            'target',
            'target_table'
        );
    }

    /**
     * Determine if the model instance has children.
     *
     * @return bool
     */
    public function getImageCategoriesAttribute()
    {
        return ImageCategory::where('target_table', $this->getTable())->get();
    }
}
