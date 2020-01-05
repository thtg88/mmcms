<?php

namespace Thtg88\MmCms\Http\Controllers;

// Events
use Thtg88\MmCms\Events\ContentFieldDestroyed;
use Thtg88\MmCms\Events\ContentFieldStored;
// Repositories
use Thtg88\MmCms\Repositories\ContentFieldRepository;
// Requests
use Thtg88\MmCms\Http\Requests\ContentField\DestroyContentFieldRequest;
use Thtg88\MmCms\Http\Requests\ContentField\StoreContentFieldRequest;
use Thtg88\MmCms\Http\Requests\ContentField\UpdateContentFieldRequest;

class ContentFieldController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param       \Thtg88\MmCms\Repositories\ContentFieldRepository        $repository
     * @return      void
     */
    public function __construct(ContentFieldRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentField\StoreContentFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentFieldRequest $request)
    {
        // Get input
        $input = $request->all();

        // Create
        $resource = $this->repository->create($input);

        event(new ContentFieldStored($resource));

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\ContentField\DestroyContentFieldRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyContentFieldRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        event(new ContentFieldDestroyed($resource));

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
