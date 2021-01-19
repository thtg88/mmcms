<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\Image\DestroyRequest;
use Thtg88\MmCms\Http\Requests\Image\StoreRequest;
use Thtg88\MmCms\Http\Requests\Image\UpdateRequest;
use Thtg88\MmCms\Services\ImageService;

class ImageController extends Controller
{
    /**
     * The controller-specific bindings.
     *
     * @var string[]|callable[]
     */
    protected $bindings = [
        DestroyRequestInterface::class => DestroyRequest::class,
        StoreRequestInterface::class   => StoreRequest::class,
        UpdateRequestInterface::class  => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\ImageService $service
     *
     * @return void
     */
    public function __construct(ImageService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
