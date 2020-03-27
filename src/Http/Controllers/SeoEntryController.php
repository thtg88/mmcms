<?php

namespace Thtg88\MmCms\Http\Controllers;

// Controllers
use Thtg88\MmCms\Http\Controllers\Controller;
use Thtg88\MmCms\Repositories\SeoEntryRepository;
use Thtg88\MmCms\Http\Requests\SeoEntry\DestroySeoEntryRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\RestoreSeoEntryRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\StoreSeoEntryRequest;
use Thtg88\MmCms\Http\Requests\SeoEntry\UpdateSeoEntryRequest;

class SeoEntryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\SeoEntryRepository $repository
     * @return void
     */
    public function __construct(SeoEntryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\SeoEntry\StoreSeoEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeoEntryRequest $request)
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
     * @param \Thtg88\MmCms\Http\Requests\SeoEntry\UpdateSeoEntryRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeoEntryRequest $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\SeoEntry\DestroySeoEntryRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroySeoEntryRequest $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\SeoEntry\RestoreSeoEntryRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreSeoEntryRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->restore($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
