<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

use Thtg88\MmCms\Http\Requests\ShowRequest as BaseShowRequest;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class ShowRequest extends BaseShowRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentMigrationMethodRepository $repository
     * @return void
     */
    public function __construct(ContentMigrationMethodRepository $repository)
    {
        $this->repository = $repository;
    }
}
