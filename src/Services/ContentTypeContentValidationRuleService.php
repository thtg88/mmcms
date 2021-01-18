<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository;

class ContentTypeContentValidationRuleService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository $repository
     *
     * @return void
     */
    public function __construct(ContentTypeContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
