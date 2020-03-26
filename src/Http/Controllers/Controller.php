<?php

namespace Thtg88\MmCms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Thtg88\MmCms\Http\Requests\IndexRequest;
use Thtg88\MmCms\Http\Requests\PaginateRequest;
use Thtg88\MmCms\Http\Requests\SearchRequest;
use Thtg88\MmCms\Http\Requests\ShowRequest;
use Thtg88\MmCms\Http\Requests\UserDateFilterRequest;
use Thtg88\MmCms\Http\Requests\UserIndexRequest;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Concerns\WithBindings;

    /**
     * The controller repository.
     *
     * @var \Thtg88\MmCms\Repositories\Repository
     */
    protected $repository;

    /**
     * The service implementation.
     *
     * @var \App\Http\Requests\Contracts\ResourceServiceInterface
     */
    protected $service;

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\Contracts\DestroyRequestInterface $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequestInterface $request, $id)
    {
        // Destroy resource
        $resource = $this->service->destroy($request, $id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Display a listing of the resources.
     *
     * @param \Thtg88\MmCms\Http\Requests\IndexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        // Get resources
        $resources = $this->repository->all();

        $response_data = ['resources' => $resources];

        return response()->json($response_data);
    }

    /**
     * Display a paginated listing of the resources.
     *
     * @param \Thtg88\MmCms\Http\Requests\PaginateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(PaginateRequest $request)
    {
        $resources = $this->service->paginate($request);

        return response()->json($resources);
    }

    /**
     * Search for the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\SearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $resources = $this->repository->search($request->q);

        return response()->json(['resources' => $resources]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Thtg88\MmCms\Http\Requests\ShowRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        $resource_name = str_singular($this->repository->getName());

        // Get resource
        $resource = $this->repository->find($id);
        if ($resource === null) {
            abort(404, ucwords(str_replace('_', ' ', $resource_name)).' not found.');
        }

        return response()->json(['resource' => $resource]);
    }

    /**
     * Display a listing of the resource belonging to the user,
     * filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\UserIndexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function userDateFilter(UserDateFilterRequest $request)
    {
        $input = $request->only(['start', 'end']);

        // Convert start and end date to object to be accepted by the repository.
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $input['start'], 'Europe/London');
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $input['end'], 'Europe/London');

        // Get resources
        $resources = $this->repository->getByUserIdAndDateFilter($request->user()->id, $start_date, $end_date);

        return response()->json(['resources' => $resources]);
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

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
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

        return response()->json([
            'success', true,
            'resource', $resource,
        ]);
    }

    /**
     * Display a listing of the resource belonging to the user.
     *
     * @param \Thtg88\MmCms\Http\Requests\UserIndexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function userIndex(UserIndexRequest $request)
    {
        // Get resources
        $resources = $this->repository->getByUserId($request->user()->id);

        return response()->json(['resources' => $resources]);
    }

    /**
     * Return the service name.
     */
    protected function getServiceName()
    {
        return $this->service->getName();
    }
}
