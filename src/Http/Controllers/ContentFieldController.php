<?php

namespace Thtg88\MmCms\Http\Controllers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\ContentField\DestroyRequest;
use Thtg88\MmCms\Http\Requests\ContentField\PaginateRequest;
use Thtg88\MmCms\Http\Requests\ContentField\ShowRequest;
use Thtg88\MmCms\Http\Requests\ContentField\StoreRequest;
use Thtg88\MmCms\Services\ContentFieldService;
use Thtg88\MmCms\Resources\ContentField\ShowResource;

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

    /**
     * Display the specified resource.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequestInterface $request, $id)
    {
        $resource = $this->service->show($request, $id)->load([
            'content_field_content_validation_rules.content_validation_rule',
            'content_type',
        ]);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['resource' => new ShowResource($resource)]);
    }
}
