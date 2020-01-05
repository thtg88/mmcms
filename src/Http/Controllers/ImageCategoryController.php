<?php

namespace Thtg88\MmCms\Http\Controllers;

// Controllers
use Thtg88\MmCms\Http\Controllers\Controller;
// Repositories
use Thtg88\MmCms\Repositories\ImageCategoryRepository;
// Requests
use Thtg88\MmCms\Http\Requests\ImageCategory\DestroyImageCategoryRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\RestoreImageCategoryRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\StoreImageCategoryRequest;
use Thtg88\MmCms\Http\Requests\ImageCategory\UpdateImageCategoryRequest;

class ImageCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageCategoryRepository        $repository
     * @return void
     */
    public function __construct(ImageCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ImageCategory\StoreImageCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageCategoryRequest $request)
    {
        // Get input
        $input = $request->except([
            'created_at',
            'deleted_at',
            'published_at',
            'updated_at',
        ]);

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
     * @param \Thtg88\MmCms\Http\Requests\ImageCategory\UpdateImageCategoryRequest  $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageCategoryRequest $request, $id)
    {
        // Get input
        $input = $request->except([
            'created_at',
            'deleted_at',
            'published_at',
            'updated_at',
        ]);

        // Update
        $resource = $this->repository->update($id, $input, false, true);

        // No need to check if found as done by authorization method

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ImageCategory\DestroyImageCategoryRequest  $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyImageCategoryRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ImageCategory\RestoreImageCategoryRequest  $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreImageCategoryRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->restore($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
