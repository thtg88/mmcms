<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\SeoEntry\DestroyRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\RestoreRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\StoreRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\UpdateRequest;
use Thtg88\MmCms\Services\SeoEntryService;

class SeoEntryController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        RestoreRequestInterface::class => RestoreRequest::class,
        StoreRequestInterface::class => StoreRequest::class,
        UpdateRequestInterface::class => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\SeoEntryService $service
     * @return void
     */
    public function __construct(SeoEntryService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
