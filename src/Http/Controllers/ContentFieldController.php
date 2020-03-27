<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentField\DestroyRequest;
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
        StoreRequestInterface::class => StoreRequest::class,
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
