<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Thtg88\MmCms\Http\Requests\RestoreRequest as BaseRestoreRequest;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

class RestoreRequest extends BaseRestoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $repository
     * @return void
     */
    public function __construct(ContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
