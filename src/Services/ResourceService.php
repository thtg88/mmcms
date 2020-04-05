<?php

namespace Thtg88\MmCms\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;

class ResourceService implements ResourceServiceInterface
{
    use Concerns\WithPagination;

    /**
     * The repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\RepositoryInterface
     */
    protected $repository;

    /**
     * Display a listing of the resource filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface $request
     * @return \Illuminate\Http\Response
     * @todo move to service
     */
    public function dateFilter(DateFilterRequestInterface $request)
    {
        $data = $request->only(['start', 'end']);

        // Convert start and end date to object to be accepted by the repository
        $start_date = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $data['start'].' 00:00:00',
            Config::get('app.timezone')
        );
        $end_date = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $data['end'].' 00:00:00',
            Config::get('app.timezone')
        );

        return $this->repository->dateFilter(
            $start_date,
            $end_date
        );
    }

    /**
     * Deletes a model instance from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface $request
     * @param int $id The id of the model.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy(DestroyRequestInterface $request, $id): Model
    {
        return $this->repository->destroy($id);
    }

    /**
     * Return the service name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->repository->getModelTable();
    }

    /**
     * Return the title-cased resource name.
     *
     * @return string
     */
    public function getResourceName()
    {
        return Str::title(
            str_replace(
                '_',
                ' ',
                Str::singular($this->getName())
            )
        );
    }

    /**
     * Return the service name.
     *
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Return all the model instances.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\IndexRequestInterface $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(IndexRequestInterface $request): Collection
    {
        return $this->repository->all();
    }

    /**
     * Restore a model instance from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function restore(RestoreRequestInterface $request, $id)
    {
        return $this->repository->restore($id);
    }

    /**
     * Return the model instances matching the given search query.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface $request
     * @return \Illuminate\Support\Collection
     */
    public function search(SearchRequestInterface $request)
    {
        // Get search query
        $query = $request->q;

        return $this->repository->search($query);
    }

    /**
     * Returns a model from a given id.
     *
     * @param int $id The id of the instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new model instance in storage from the given request.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRequestInterface $request)
    {
        // Get request data
        $data = $request->validated();

        return $this->repository->create($data);
    }

    /**
     * Updates a model instance with given request, and id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface $request
     * @param int $id The id of the model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(UpdateRequestInterface $request, $id)
    {
        // Get request data
        $data = $request->validated();

        return $this->repository->update($id, $data);
    }

    /**
     * Display a listing of the resource filtered by a given start and end date.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\DateFilterRequestInterface $request
     * @return \Illuminate\Http\Response
     * @todo move to service
     */
    public function userDateFilter(DateFilterRequestInterface $request)
    {
        $data = $request->only(['start', 'end']);

        // Convert start and end date to object to be accepted by the repository
        $start_date = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $data['start'].' 00:00:00',
            Config::get('app.timezone')
        );
        $end_date = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $data['end'].' 00:00:00',
            Config::get('app.timezone')
        );

        return $this->repository->getByUserIdAndDateFilter(
            $request->user()->id,
            $start_date,
            $end_date
        );
    }
}
