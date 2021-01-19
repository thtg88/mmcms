<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Restore;

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
        return route('mmcms.image-categories.restore', ['id' => $parameters[0]]);
    }
}
