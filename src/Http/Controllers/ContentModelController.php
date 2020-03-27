<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Events\ContentModelStored;
use Thtg88\MmCms\Repositories\ContentModelRepository;
use Thtg88\MmCms\Http\Requests\ContentModel\DestroyContentModelRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\StoreContentModelRequest;
use Thtg88\MmCms\Http\Requests\ContentModel\UpdateContentModelRequest;

class ContentModelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentModelRepository $repository
     * @return void
     */
    public function __construct(ContentModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ContentModel\StoreContentModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentModelRequest $request)
    {
        // Get input
        $input = $request->all();

        if (!array_key_exists('base_route_name', $input) || empty($input['base_route_name'])) {
            // If base route name is not provided we build it
            // We first get all the lowercase words
            // We pluralize the last
            // And finally we separate them by hyphens instead of spaces

            // Get words
            $words = explode(' ', strtolower($input['name']));

            $input['base_route_name'] = implode(
                '-',
                array_map(
                    function ($word, $idx) use ($words) {
                        return $idx === count($words) - 1
                            ? str_plural($word)
                            : $word;
                    },
                    $words,
                    array_keys($words)
                )
            );
        }

        if (!array_key_exists('model_name', $input) || empty($input['model_name'])) {
            // If model name is not provided we build it
            // By studly casing the name
            $input['model_name'] = studly_case($input['name']);
        }

        if (!array_key_exists('table_name', $input) || empty($input['table_name'])) {
            // If table name is not provided we build it
            // We first get all the lowercase words
            // We pluralize the last
            // And finally we separate them by underscores instead of spaces

            // Get words
            $words = explode(' ', strtolower($input['name']));

            $input['table_name'] = implode(
                '_',
                array_map(
                    function ($word, $idx) use ($words) {
                        return $idx === count($words) - 1
                            ? str_plural($word)
                            : $word;
                    },
                    $words,
                    array_keys($words)
                )
            );
        }

        // Create
        $resource = $this->repository->create($input);

        event(new ContentModelStored($resource));

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\ContentModel\UpdateContentModelRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentModelRequest $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\ContentModel\DestroyContentModelRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyContentModelRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
