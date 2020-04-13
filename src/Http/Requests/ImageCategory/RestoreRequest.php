<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Http\Requests\RestoreRequest as BaseRestoreRequest;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class RestoreRequest extends BaseRestoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageCategoryRepository $repository
     * @return void
     */
    public function __construct(ImageCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}
