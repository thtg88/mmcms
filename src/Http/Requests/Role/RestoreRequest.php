<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Thtg88\MmCms\Http\Requests\RestoreRequest as BaseRestoreRequest;
use Thtg88\MmCms\Repositories\RoleRepository;

class RestoreRequest extends BaseRestoreRequest
{
    /**
     * Create a new request instance.
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
