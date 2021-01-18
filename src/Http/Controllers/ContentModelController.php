<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\ContentModel\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\IndexRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\PaginateRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\RestoreRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\ShowRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\UpdateRequest;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Services\ContentModelService;

class ContentModelController extends Controller
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
     * @param \Thtg88\MmCms\Services\ContentModelService $service
     *
     * @return void
     */
    public function __construct(ContentModelService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
