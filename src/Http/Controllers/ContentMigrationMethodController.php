<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\IndexRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\PaginateRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\RestoreRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\ShowRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\UpdateRequest;
use Thtg88\MmCms\Services\ContentMigrationMethodService;

class ContentMigrationMethodController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        IndexRequestInterface::class => IndexRequest::class,
        PaginateRequestInterface::class => PaginateRequest::class,
        RestoreRequestInterface::class => RestoreRequest::class,
        ShowRequestInterface::class => ShowRequest::class,
        StoreRequestInterface::class => StoreRequest::class,
        UpdateRequestInterface::class => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ContentMigrationMethodService $service
     * @return void
     */
    public function __construct(ContentMigrationMethodService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
