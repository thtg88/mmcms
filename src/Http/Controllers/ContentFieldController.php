<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentField\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentField\PaginateRequest;
use Thtg88\MmCms\Http\Requests\ContentField\ShowRequest;
use Thtg88\MmCms\Http\Requests\ContentField\StoreRequest;
use Thtg88\MmCms\Services\ContentFieldService;

class ContentFieldController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        PaginateRequestInterface::class => PaginateRequest::class,
        ShowRequestInterface::class => ShowRequest::class,
        StoreRequestInterface::class => StoreRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ContentFieldService $service
     * @return void
     */
    public function __construct(ContentFieldService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
