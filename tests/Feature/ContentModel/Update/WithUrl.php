<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Update;

trait WithUrl
{
    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function getRoute(array $parameters = []): string
    {
        return route('mmcms.content-models.update', ['id' => $parameters[0]]);
    }
}
