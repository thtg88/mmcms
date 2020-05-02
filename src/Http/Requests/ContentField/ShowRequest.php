<?php

namespace Thtg88\MmCms\Http\Requests\ContentField;

use Thtg88\MmCms\Http\Requests\ShowRequest as BaseShowRequest;
use Thtg88\MmCms\Repositories\ContentFieldRepository;

class ShowRequest extends BaseShowRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldRepository $repository
     * @return void
     */
    public function __construct(ContentFieldRepository $repository)
    {
        $this->repository = $repository;
    }
}
