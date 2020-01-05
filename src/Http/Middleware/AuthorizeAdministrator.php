<?php

namespace Thtg88\MmCms\Http\Middleware;

use Closure;
// Repositories
use Thtg88\MmCms\Repositories\RoleRepository;

class AuthorizeAdministrator
{
    /**
     * Create a new middleware instance.
     *
     * @param	\Thtg88\MmCms\Repositories\RoleRepository	$roles
     * @return	void
     */
    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
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

        if ($user->role === null) {
            abort(403, 'This action is unauthorized.');
        }

        // Get administrator role
        $administrator_role = $this->roles->findByModelName(config('mmcms.roles.administrator_role_name'));

        if ($administrator_role === null) {
            abort(403, 'This action is unauthorized!');
        }

        if ($user->role->priority > $administrator_role->priority) {
            abort(403, 'This action is unauthorized!!');
        }

        return $next($request);
    }
}
