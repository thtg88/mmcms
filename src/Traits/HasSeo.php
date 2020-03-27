<?php

namespace Thtg88\MmCms\Traits;

use Illuminate\Support\Facades\Config;

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
            Config::get('mmcms.models.namespace').'SeoEntry',
            'target',
            'target_table'
        );
    }
}
