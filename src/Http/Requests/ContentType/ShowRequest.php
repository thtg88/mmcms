<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\ShowRequest as BaseShowRequest;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class ShowRequest extends BaseShowRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $repository
     * @return void
     */
    public function __construct(ContentTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
