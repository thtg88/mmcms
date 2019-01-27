<?php

namespace Thtg88\MmCms\Http\Controllers;

// Repositories
use Thtg88\MmCms\Repositories\ContentModelRepository;
// Requests
use Thtg88\MmCms\Http\Requests\ContentModel\DestroyContentModelRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\StoreContentModelRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\UpdateContentModelRequest;

class ContentModelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param       \Thtg88\MmCms\Repositories\ContentModelRepository        $repository
     * @return      void
     */
    public function __construct(ContentModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentModel\StoreContentModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentModelRequest $request)
    {
        // Get input
        $input = $request->all();

        // Create
        $resource = $this->repository->create($input);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentModel\UpdateContentModelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentModelRequest $request, $id)
    {
        // Get input
        $input = $request->all();

        // Update
        $resource = $this->repository->update($id, $input);

        // No need to check if found as done by authorization method

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentModel\DestroyContentModelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyContentModelRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
