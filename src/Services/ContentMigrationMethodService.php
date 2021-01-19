<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class ContentMigrationMethodService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentMigrationMethodRepository $repository
     *
     * @return void
     */
    public function __construct(ContentMigrationMethodRepository $repository)
    {
        $this->repository = $repository;
    }
}
