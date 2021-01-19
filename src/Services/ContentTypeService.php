<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentTypeRepository;

class ContentTypeService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $repository
     *
     * @return void
     */
    public function __construct(ContentTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
