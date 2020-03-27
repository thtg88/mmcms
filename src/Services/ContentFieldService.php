<?php

namespace Thtg88\MmCms\Services;

use Illuminate\Container\Container;
use Thtg88\MmCms\Events\ContentFieldDestroyed;
use Thtg88\MmCms\Events\ContentFieldStored;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Repositories\ContentFieldRepository;

class ContentFieldService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldRepository $repository
     * @return void
     */
    public function __construct(ContentFieldRepository $repository)
    {
        $this->repository = $repository;
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

        // Create
        $resource = $this->repository->create($data);

        Container::getInstance()->make('events', [])
            ->dispatch(new ContentFieldStored($resource));

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
        // Delete resource
        $resource = $this->repository->destroy($id);

        Container::getInstance()->make('events', [])
            ->dispatch(new ContentFieldDestroyed($resource));

        return $resource;
    }
}
