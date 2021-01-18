<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\ContentFieldContentValidationRule\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentFieldContentValidationRule\StoreRequest;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Services\ContentFieldContentValidationRuleService;

class ContentFieldContentValidationRuleController extends Controller
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
     * @param \Thtg88\MmCms\Services\ContentFieldContentValidationRuleService $service
     *
     * @return void
     */
    public function __construct(ContentFieldContentValidationRuleService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
