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
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\SearchRequest;
use Thtg88\MmCms\Http\Requests\ShowRequest;
use Thtg88\MmCms\Http\Requests\UserIndexRequest;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Concerns\WithBindings;

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
            ->json(['resources' => $resources]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequestInterface $request, $id)
    {
        // Destroy resource
        $resource = $this->service->destroy($request, $id);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['success' => true, 'resource' => $resource]);
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
            ->json(['resources' => $resources]);
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

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json($resources);
    }

    /**
     * Search for the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $resources = $this->service->getRepository()->search($request->q);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['resources' => $resources]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Thtg88\MmCms\Http\Requests\ShowRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        $resource = $this->service->show($id);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['resource' => $resource]);
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
            ->json(['resources' => $resources]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestInterface $request)
    {
        // Store resource
        $resource = $this->service->store($request);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['success' => true, 'resource' => $resource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Contracts\UpdateRequestInterface $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestInterface $request, $id)
    {
        // Update resource
        $resource = $this->service->update($request, $id);

        return Container::getInstance()
            ->make(ResponseFactory::class, [])
            ->json(['success' => true, 'resource' => $resource]);
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
            ->json(['resources' => $resources]);
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
