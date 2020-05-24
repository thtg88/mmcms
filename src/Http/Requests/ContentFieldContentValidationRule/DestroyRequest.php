<?php

namespace Thtg88\MmCms\Http\Requests\ContentFieldContentValidationRule;

use Thtg88\MmCms\Http\Requests\DestroyRequest as BaseDestroyRequest;
use Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository;

class DestroyRequest extends BaseDestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository $repository
     * @return void
     */
    public function __construct(ContentFieldContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
