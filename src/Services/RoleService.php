<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\RoleRepository;

class RoleService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\RoleRepository $repository
     *
     * @return void
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }
}
