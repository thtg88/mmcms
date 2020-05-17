<?php

namespace Thtg88\MmCms\Http\Requests\ContentTypeContentValidationRule;

use Thtg88\MmCms\Http\Requests\DestroyRequest as BaseDestroyRequest;
use Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository;

class DestroyRequest extends BaseDestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository $repository
     * @return void
     */
    public function __construct(ContentTypeContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
