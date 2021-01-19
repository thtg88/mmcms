<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\ShowRequest as BaseShowRequest;
use Thtg88\MmCms\Repositories\SeoEntryRepository;

class ShowRequest extends BaseShowRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\SeoEntryRepository $repository
     *
     * @return void
     */
    public function __construct(SeoEntryRepository $repository)
    {
        $this->repository = $repository;
    }
}
