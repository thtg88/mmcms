<?php

namespace Thtg88\MmCms\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Controllers
use Thtg88\MmCms\Http\Controllers\Controller;
use Thtg88\MmCms\Helpers\FileHelper;
use Thtg88\MmCms\Repositories\ImageRepository;
use Thtg88\MmCms\Http\Requests\Image\DestroyImageRequest;
use Thtg88\MmCms\Http\Requests\Image\StoreImageRequest;
use Thtg88\MmCms\Http\Requests\Image\UpdateImageRequest;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageRepository $repository
     * @param \Thtg88\MmCms\Helpers\FileHelper $file_helper
     * @return void
     */
    public function __construct(ImageRepository $repository, FileHelper $file_helper)
    {
        $this->repository = $repository;
        $this->file_helper = $file_helper;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Image\StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        // Get input
        $input = $request->except([
            'created_at',
            'deleted_at',
            'published_at',
            'updated_at',
        ]);

        if ($request->hasFile('data') && $request->file('data')->isValid()) {
            // Get path from uploaded file
            $input['url'] = $this->file_helper->store($request->data, $this->repository);

            unset($input['data']);
        }

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
     * @param \Thtg88\MmCms\Http\Requests\Image\UpdateImageRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, $id)
    {
        // Get input
        $input = $request->except([
            'created_at',
            'deleted_at',
            'published_at',
            'updated_at',
            // Can't update a file via PUT (sic...)
            // https://bugs.php.net/bug.php?id=55815
            'data',
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
     * @param \Thtg88\MmCms\Http\Requests\Image\DestroyImageRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyImageRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        if (Str::startsWith($resource->url, '/storage/userfiles')) {
            $path = storage_path('app/public'.substr($resource->url, strlen('/storage')));

            if (is_file($path) && is_readable($path)) {
                // remove from FS
                unlink($path);
            }
        }

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
