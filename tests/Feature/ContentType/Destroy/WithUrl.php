<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Destroy;

trait WithUrl
{
    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string
    {
        return route('mmcms.content-types.destroy', ['id' => $parameters[0]]);
    }
}
