<?php

namespace SdSomersetDesign\CastleCombe\Traits;

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
            'SdSomersetDesign\CastleCombe\Models\SeoEntry',
            'target',
            'target_table'
        );
    }
}
