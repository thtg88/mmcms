<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\ContentValidationRuleAdditionalFieldType\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRuleAdditionalFieldType\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRuleAdditionalFieldType\UpdateRequest;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Services\ContentValidationRuleAdditionalFieldTypeService;

class ContentValidationRuleAdditionalFieldTypeController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        StoreRequestInterface::class => StoreRequest::class,
        UpdateRequestInterface::class => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ContentValidationRuleAdditionalFieldTypeService $service
     * @return void
     */
    public function __construct(ContentValidationRuleAdditionalFieldTypeService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
