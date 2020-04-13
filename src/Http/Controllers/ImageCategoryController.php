<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\ImageCategory\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\IndexRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\RestoreRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\StoreRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\UpdateRequest;
use Thtg88\MmCms\Services\ImageCategoryService;

class ImageCategoryController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        IndexRequestInterface::class => IndexRequest::class,
        RestoreRequestInterface::class => RestoreRequest::class,
        StoreRequestInterface::class => StoreRequest::class,
        UpdateRequestInterface::class => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ImageCategoryService $service
     * @return void
     */
    public function __construct(ImageCategoryService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
