<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Thtg88\MmCms\Http\Requests\RestoreRequest as BaseRestoreRequest;
use Thtg88\MmCms\Repositories\ContentModelRepository;

class RestoreRequest extends BaseRestoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentModelRepository $repository
     *
     * @return void
     */
    public function __construct(ContentModelRepository $repository)
    {
        $this->repository = $repository;
    }
}
