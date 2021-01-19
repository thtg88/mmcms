<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class ImageCategoryService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageCategoryRepository $repository
     *
     * @return void
     */
    public function __construct(ImageCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}
