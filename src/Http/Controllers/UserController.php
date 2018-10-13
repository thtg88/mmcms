<?php

namespace Thtg88\MmCms\Http\Controllers;

// Repositories
use Thtg88\MmCms\Repositories\UserRepository;
// Requests
use Thtg88\MmCms\Http\Requests\User\DestroyUserRequest;
use Thtg88\MmCms\Http\Requests\User\StoreUserRequest;
use Thtg88\MmCms\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param       \Thtg88\MmCms\Repositories\UserRepository        $users
     * @return      void
     */
    public function __construct(UserRepository $users)
    {
        $this->repository = $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Thtg88\MmCms\Http\Requests\User\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // Get input
        $input = $request->except(['created_at']);

        if(array_key_exists('password', $input) && !empty($input['password']))
        {
            $input['password'] = bcrypt($input['password']);
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
     * @param  \Thtg88\MmCms\Http\Requests\User\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // Get input
        $input = $request->except(['created_at']);

        if(array_key_exists('password', $input) && !empty($input['password']))
        {
            $input['password'] = bcrypt($input['password']);
        }

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
     * @param  \Thtg88\MmCms\Http\Requests\User\DestroyUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyUserRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
