<?php

namespace Thtg88\MmCms\Http\Controllers;

// Repositories
use Thtg88\MmCms\Repositories\ContentTypeRepository;
// Requests
use Thtg88\MmCms\Http\Requests\ContentType\DestroyContentTypeRequest;
use Thtg88\MmCms\Http\Requests\ContentType\StoreContentTypeRequest;
use Thtg88\MmCms\Http\Requests\ContentType\UpdateContentTypeRequest;

class ContentTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param       \Thtg88\MmCms\Repositories\ContentTypeRepository        $repository
     * @return      void
     */
    public function __construct(ContentTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentType\StoreContentTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentTypeRequest $request)
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
     * @param  \Thtg88\MmCms\Http\Requests\ContentType\UpdateContentTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentTypeRequest $request, $id)
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
     * @param  \Thtg88\MmCms\Http\Requests\ContentType\DestroyContentTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyContentTypeRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
