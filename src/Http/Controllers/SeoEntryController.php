<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\SeoEntry\DestroyRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\IndexRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\PaginateRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\RestoreRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\ShowRequest;
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
        DestroyRequestInterface::class  => DestroyRequest::class,
        IndexRequestInterface::class    => IndexRequest::class,
        PaginateRequestInterface::class => PaginateRequest::class,
        RestoreRequestInterface::class  => RestoreRequest::class,
        ShowRequestInterface::class     => ShowRequest::class,
        StoreRequestInterface::class    => StoreRequest::class,
        UpdateRequestInterface::class   => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\SeoEntryService $service
     *
     * @return void
     */
    public function __construct(SeoEntryService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
