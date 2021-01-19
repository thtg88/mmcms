<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\ContentTypeContentValidationRule\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentTypeContentValidationRule\StoreRequest;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Services\ContentTypeContentValidationRuleService;

class ContentTypeContentValidationRuleController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        StoreRequestInterface::class   => StoreRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ContentTypeContentValidationRuleService $service
     *
     * @return void
     */
    public function __construct(ContentTypeContentValidationRuleService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
