<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\User\DestroyRequest;
use Thtg88\MmCms\Http\Requests\User\IndexRequest;
use Thtg88\MmCms\Http\Requests\User\PaginateRequest;
use Thtg88\MmCms\Http\Requests\User\StoreRequest;
use Thtg88\MmCms\Http\Requests\User\UpdateRequest;
use Thtg88\MmCms\Services\UserService;

class UserController extends Controller
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
        StoreRequestInterface::class => StoreRequest::class,
        UpdateRequestInterface::class => UpdateRequest::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Services\UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;

        parent::__construct();
    }
}
