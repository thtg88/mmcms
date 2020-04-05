<?php

namespace Thtg88\MmCms\Http\Middleware;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Helpers\UserRoleHelper;

class AuthorizeDeveloper
{
    /**
     * The role repository implementation.
     *
     * @var \Thtg88\MmCms\Helpers\UserRoleHelper
     */
    protected $user_role_helper;

    /**
     * Create a new middleware instance.
     *
     * @param \Thtg88\MmCms\Helpers\UserRoleHelper $user_role_helper
     * @return void
     */
    public function __construct(UserRoleHelper $user_role_helper)
    {
        $this->user_role_helper = $user_role_helper;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get current user from request object
        $user = $request->user();

        if ($this->user_role_helper->authorizeDeveloper($user) === false) {
            Container::getInstance()
                ->abort(403, 'This action is unauthorized!!', []);
        }

        return $next($request);
    }
}
