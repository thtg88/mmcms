<?php

namespace Thtg88\MmCms\Services;

use Carbon\Carbon;
use Illuminate\Config\Repository as Config;
use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\SearchRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;
use Illuminate\Support\Str;

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
    public function destroy(DestroyRequestInterface $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface $request
     * @return \Illuminate\Support\Collection
     */
    public function paginate(PaginateRequestInterface $request)
    {
        // Get input
        $input = $request->only([
            'page',
            'page_size',
            'recovery',
            'sort_direction',
            'sort_name',
        ]);

        $wheres = [];

        $wheres = array_merge($wheres, $this->getFilterValues($request));

        // Page falls back to 1
        if (! array_key_exists('page', $input) || $input['page'] === null) {
            $input['page'] = 1;
        }

        // Page size fall back to configs
        if (
            ! array_key_exists('page_size', $input) ||
            $input['page_size'] === null ||
            filter_var($input['page_size'], FILTER_VALIDATE_INT) === false
        ) {
            $input['page_size'] = Config::get('app.pagination.page_size');
        }

        $input['q'] = $this->getSearchValue($request);

        if (array_key_exists('recovery', $input) && $input['recovery'] == 1) {
            // Set the repository to also fetch trashed models
            $this->repository = $this->repository->withTrashed();

            $wheres[] = [
                'field' => 'deleted_at',
                'operator' => '<>',
                'value' => null,
            ];
        }

        // Sort name fall back
        if (empty($input['sort_name'])) {
            $input['sort_name'] = null;
        }

        // Sort direction fall back
        if (empty($input['sort_direction'])) {
            $input['sort_direction'] = null;
        }

        // Get paginated resources
        return $this->repository->paginate(
            $input['page_size'],
            $input['page'],
            $input['q'],
            $input['sort_name'],
            $input['sort_direction'],
            $wheres
        );
    }

    /**
     * Restore a model instance from a given id.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface $request
     * @param int    $id The id of the model
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
