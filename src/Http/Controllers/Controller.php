<?php

namespace Thtg88\MmCms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// Requests
use Thtg88\MmCms\Http\Requests\IndexRequest;
use Thtg88\MmCms\Http\Requests\PaginateRequest;
use Thtg88\MmCms\Http\Requests\SearchRequest;
use Thtg88\MmCms\Http\Requests\ShowRequest;
use Thtg88\MmCms\Http\Requests\UserDateFilterRequest;
use Thtg88\MmCms\Http\Requests\UserIndexRequest;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The controller repository.
     *
     * @var \Thtg88\MmCms\Repositories\Repository
     */
    protected $repository;

    /**
     * Display a listing of the resources.
     *
     * @param  \Thtg88\MmCms\Http\Requests\IndexRequest  $request
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
     * @param  \Thtg88\MmCms\Http\Requests\PaginateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(PaginateRequest $request)
    {
        // Get input
        $input = $request->only([
            'page',
            'page_size',
            'q'
        ]);

        if(!array_key_exists('page', $input) || $input['page'] === null)
        {
            $input['page'] = 1;
        }

        if(!array_key_exists('page_size', $input) || $input['page_size'] === null)
        {
            $input['page_size'] = config('mmcms.pagination.page_size');
        }

        if(!array_key_exists('q', $input))
        {
            $q = null;
        }
        else
        {
            $q = $input['q'];
        }

        // Get resources
        $resources = $this->repository->paginate($input['page_size'], $input['page'], $q);

        $response_data = $resources;

        return response()->json($response_data);
    }

    /**
     * Search for the specified resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\SearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        // Get resources
        $resources = $this->repository->search($request->q);

        return response()->json(['resources' => $resources, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ShowRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        $resource_name = str_singular($this->repository->getName());

        // Get resource
        $resource = $this->repository->find($id);
        if($resource === null)
        {
            abort(404, ucwords(str_replace('_', ' ', $resource_name)).' not found.');
        }

        return response()->json(['resource' => $resource]);
    }

    /**
     * Display a listing of the resource belonging to the user,
     * filtered by a given start and end date.
     *
     * @param  \Thtg88\MmCms\Http\Requests\UserIndexRequest  $request
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

        return response()->json(['resources' => $resources, ]);
    }

    /**
     * Display a listing of the resource belonging to the user.
     *
     * @param  \Thtg88\MmCms\Http\Requests\UserIndexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function userIndex(UserIndexRequest $request)
    {
        // Get resources
        $resources = $this->repository->getByUserId($request->user()->id);

        return response()->json(['resources' => $resources, ]);
    }
}
