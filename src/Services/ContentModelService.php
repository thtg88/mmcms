<?php

namespace Thtg88\MmCms\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Repositories\ContentModelRepository;

class ContentModelService extends ResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentModelRepository $repository
     *
     * @return void
     */
    public function __construct(ContentModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRequestInterface $request)
    {
        $data = $request->validated();

        if (
            !array_key_exists('base_route_name', $data) ||
            empty($data['base_route_name'])
        ) {
            // If base route name is not provided we build it
            // We first get all the lowercase words
            // We pluralize the last
            // And finally we separate them by hyphens instead of spaces

            // Get words
            $words = explode(' ', strtolower($data['name']));

            $data['base_route_name'] = implode(
                '-',
                array_map(
                    function ($word, $idx) use ($words) {
                        return $idx === count($words) - 1
                            ? Str::plural($word)
                            : $word;
                    },
                    $words,
                    array_keys($words)
                )
            );
        }

        if (
            !array_key_exists('model_name', $data) ||
            empty($data['model_name'])
        ) {
            // If model name is not provided we build it
            // By studly casing the name
            $data['model_name'] = Str::studly($data['name']);
        }

        // If table name is not provided we build it
        // We first get all the lowercase words
        // We pluralize the last
        // And finally we separate them by underscores instead of spaces
        if (
            !array_key_exists('table_name', $data) ||
            empty($data['table_name'])
        ) {
            // Get words
            $words = explode(' ', strtolower($data['name']));

            $data['table_name'] = implode(
                '_',
                array_map(
                    function ($word, $idx) use ($words) {
                        return $idx === count($words) - 1
                            ? Str::plural($word)
                            : $word;
                    },
                    $words,
                    array_keys($words)
                )
            );
        }

        $resource = $this->repository->create($data);

        Container::getInstance()->make('events', [])
            ->dispatch(new ContentModelStored($resource));

        return $resource;
    }
}
