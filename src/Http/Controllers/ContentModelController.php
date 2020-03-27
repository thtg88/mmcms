<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentModel\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\UpdateRequest;
use Thtg88\MmCms\Services\ContentModelService;

class ContentModelController extends Controller
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
     * @param \App\Services\ContentModelService $service
     * @return void
     */
    public function __construct(ContentModelService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
