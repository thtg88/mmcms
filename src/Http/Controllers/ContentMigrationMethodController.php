<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\DestroyContentMigrationMethodRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\StoreContentMigrationMethodRequest;
use Thtg88\MmCms\Http\Requests\ContentMigrationMethod\UpdateContentMigrationMethodRequest;

class ContentMigrationMethodController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentMigrationMethodRepository $repository
     * @return void
     */
    public function __construct(ContentMigrationMethodRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ContentMigrationMethod\StoreContentMigrationMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentMigrationMethodRequest $request)
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
     * @param \Thtg88\MmCms\Http\Requests\ContentMigrationMethod\UpdateContentMigrationMethodRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentMigrationMethodRequest $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\ContentMigrationMethod\DestroyContentMigrationMethodRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyContentMigrationMethodRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
