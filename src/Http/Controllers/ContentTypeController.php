<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentType\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentType\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentType\UpdateRequest;
use Thtg88\MmCms\Services\ContentTypeService;

class ContentTypeController extends Controller
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
     * @param \Thtg88\MmCms\Services\ContentTypeService $service
     * @return void
     */
    public function __construct(ContentTypeService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
