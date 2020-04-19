<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Show;

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
        return route('mmcms.content-migration-methods.show', ['id' => $parameters[0]]);
    }
}
