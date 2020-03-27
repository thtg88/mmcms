<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\SeoEntryRepository;

class SeoEntryService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\SeoEntryRepository $repository
     * @return void
     */
    public function __construct(SeoEntryRepository $repository)
    {
        $this->repository = $repository;
    }
}
