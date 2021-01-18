<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Thtg88\MmCms\Http\Requests\DestroyRequest as BaseDestroyRequest;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

class DestroyRequest extends BaseDestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $repository
     *
     * @return void
     */
    public function __construct(ContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
