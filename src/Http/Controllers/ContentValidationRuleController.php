<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\ContentValidationRule\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\IndexRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\PaginateRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\RestoreRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\SearchRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\ShowRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\StoreRequest;
use Thtg88\MmCms\Http\Requests\ContentValidationRule\UpdateRequest;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Services\ContentValidationRuleService;

class ContentValidationRuleController extends Controller
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
        SearchRequestInterface::class   => SearchRequest::class,
        ShowRequestInterface::class     => ShowRequest::class,
        StoreRequestInterface::class    => StoreRequest::class,
        UpdateRequestInterface::class   => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ContentValidationRuleService $service
     *
     * @return void
     */
    public function __construct(ContentValidationRuleService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
