<?php

namespace Thtg88\MmCms\Services;

use Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;

interface ResourceServiceInterface
{
    /**
     * Display a listing of the resource filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface $request
     * @return \Illuminate\Http\Response
     * @todo move to service
     */
    public function dateFilter(DateFilterRequestInterface $request);

    /**
     * Deletes a model instance from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface $request
     * @param int $id The id of the model.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy(DestroyRequestInterface $request, $id);

    /**
     * Return the service name.
     *
     * @return string
     */
    public function getName();

    /**
     * Return all the model instances.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface $request
     * @return \Illuminate\Support\Collection
     */
    public function paginate(PaginateRequestInterface $request);

    /**
     * Restore a model instance from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function restore(RestoreRequestInterface $request, $id);

    /**
     * Return the model instances matching the given search query.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface $request
     * @return \Illuminate\Support\Collection
     */
    public function search(SearchRequestInterface $request);

    /**
     * Returns a model from a given id.
     *
     * @param int $id The id of the instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id);

    /**
     * Create a new model instance in storage from the given data array.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRequestInterface $request);

    /**
     * Updates a model instance with given data, from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(UpdateRequestInterface $request, $id);
}
