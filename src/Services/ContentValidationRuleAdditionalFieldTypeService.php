<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository;

class ContentValidationRuleAdditionalFieldTypeService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository $repository
     *
     * @return void
     */
    public function __construct(ContentValidationRuleAdditionalFieldTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
