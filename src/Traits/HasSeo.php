<?php

namespace Thtg88\MmCms\Traits;

trait HasSeo
{
    /**
     * Determine if the model instance has SEO entries
     *
     * @return bool
     */
    public function seo_entry()
    {
        return $this->morphOne(
            config('mmcms.models.namespace').'SeoEntry',
            'target',
            'target_table'
        );
    }
}
