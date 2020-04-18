<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Http\Requests\ShowRequest as BaseShowRequest;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class ShowRequest extends BaseShowRequest
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
