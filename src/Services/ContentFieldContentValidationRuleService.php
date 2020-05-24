<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository;

class ContentFieldContentValidationRuleService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository $repository
     * @return void
     */
    public function __construct(ContentFieldContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
