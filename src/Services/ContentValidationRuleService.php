<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

class ContentValidationRuleService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $repository
     * @return void
     */
    public function __construct(ContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
