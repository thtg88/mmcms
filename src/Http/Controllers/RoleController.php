<?php

namespace Thtg88\MmCms\Http\Controllers;

use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Http\Requests\Role\DestroyRoleRequest;
use Thtg88\MmCms\Http\Requests\Role\StoreRoleRequest;
use Thtg88\MmCms\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\RoleRepository $repository
     * @return void
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Role\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        // Get input
        $input = $request->all();

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
     * @param \Thtg88\MmCms\Http\Requests\Role\UpdateRoleRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
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
     * @param \Thtg88\MmCms\Http\Requests\Role\DestroyRoleRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRoleRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
