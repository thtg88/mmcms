<?php

namespace Thtg88\MmCms\Http\Controllers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\ShowRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\UserIndexRequest;
use Thtg88\MmCms\Http\Resources\Resource;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Concerns\WithBindings;

    /**
     * The API resource class name.
     *
     * @var string
     */
    protected $resource_classname = Resource::class;

    /**
     * The service implementation.
     *
     * @var \Thtg88\MmCms\Http\Requests\Contracts\ResourceServiceInterface
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addBindings();
    }

    /**
     * Display a listing of the resource filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function dateFilter(DateFilterRequestInterface $request)
    {
        $resources = $this->service->dateFilter($request);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'resources' => $this->resource_classname::collection(
                    $resources
                ),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequestInterface $request, $id)
    {
        // Destroy resource
        $resource = $this->service->destroy($request, $id);

        $resource_classname = $this->resource_classname;

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'success' => true,
                'resource' => new $resource_classname($resource),
            ]);
    }

    /**
     * Display a listing of the resources.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequestInterface $request)
    {
        $resources = $this->service->getRepository()->all();

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'resources' => $this->resource_classname::collection(
                    $resources
                ),
            ]);
    }

    /**
     * Display a paginated listing of the resources.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(PaginateRequestInterface $request)
    {
        $resources = $this->service->paginate($request);

        return $this->resource_classname::collection($resources);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreRequestInterface $request, $id)
    {
        $resource = $this->service->restore($request, $id);

        $resource_classname = $this->resource_classname;

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'success' => true,
                'resource' => new $resource_classname($resource),
            ]);
    }

    /**
     * Search for the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\SearchRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequestInterface $request)
    {
        $resources = $this->service->getRepository()->search($request->q);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'resources' => $this->resource_classname::collection(
                    $resources
                ),
            ]);
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
        $resource = $this->service->show($request, $id);

        $resource_classname = $this->resource_classname;

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['resource' => new $resource_classname($resource)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestInterface $request)
    {
        // Store resource
        $resource = $this->service->store($request);

        $resource_classname = $this->resource_classname;

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'success' => true,
                'resource' => new $resource_classname($resource),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestInterface $request, $id)
    {
        // Update resource
        $resource = $this->service->update($request, $id);

        $resource_classname = $this->resource_classname;

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'success' => true,
                'resource' => new $resource_classname($resource),
            ]);
    }

    /**
     * Display a listing of the resource belonging to the user,
     * filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function userDateFilter(DateFilterRequestInterface $request)
    {
        $resources = $this->service->userDateFilter($request);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'resources' => $this->resource_classname::collection(
                    $resources
                ),
            ]);
    }

    /**
     * Display a listing of the resource belonging to the user.
     *
     * @param \Thtg88\MmCms\Http\Requests\UserIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function userIndex(UserIndexRequest $request)
    {
        // Get resources
        $resources = $this->service->getRepository()
            ->getByUserId($request->user()->id);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json([
                'resources' => $this->resource_classname::collection(
                    $resources
                ),
            ]);
    }

    /**
     * Return the service name.
     *
     * @return string
     */
    protected function getServiceName()
    {
        return $this->service->getName();
    }
}
