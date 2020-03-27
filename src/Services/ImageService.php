<?php

namespace Thtg88\MmCms\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Thtg88\MmCms\Helpers\FileHelper;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Repositories\ImageRepository;

class ImageService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageRepository $repository
     * @param \Thtg88\MmCms\Helpers\FileHelper $file_helper
     * @return void
     */
    public function __construct(
        ImageRepository $repository,
        FileHelper $file_helper
    ) {
        $this->repository = $repository;
        $this->file_helper = $file_helper;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRequestInterface $request)
    {
        $data = $request->validated();

        if ($request->hasFile('data') && $request->file('data')->isValid()) {
            // Get path from uploaded file
            $data['url'] = $this->file_helper
                ->store($data['data'], $this->repository);

            unset($data['data']);
        }

        $resource = $this->repository->create($data);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface $request
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy(DestroyRequestInterface $request, $id)
    {
        $resource = $this->repository->destroy($id);

        if (Str::startsWith($resource->url, '/storage/userfiles')) {
            $path = Container::getInstance()->make('path.storage').
                DIRECTORY_SEPARATOR.'app/public'.
                substr($resource->url, strlen('/storage'));

            if (is_file($path) && is_readable($path)) {
                // remove from FS
                unlink($path);
            }
        }

        return $resource;
    }
}
