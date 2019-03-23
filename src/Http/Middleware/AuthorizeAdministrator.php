<?php

namespace SdSomersetDesign\CastleCombe\Http\Middleware;

use Closure;
// Repositories
use SdSomersetDesign\CastleCombe\Repositories\RoleRepository;

class AuthorizeAdministrator
{
	/**
	 * Create a new middleware instance.
	 *
	 * @param	\SdSomersetDesign\CastleCombe\Repositories\RoleRepository	$roles
	 * @return	void
	 */
	public function __construct(RoleRepository $roles)
	{
		$this->roles = $roles;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Get current user from request object
	    $user = $request->user();

        if($user->role === null)
	    {
		    abort(403, 'This action is unauthorized.');
	    }

        // Get administrator role
		$administrator_role = $this->roles->find(config('castle-combe.administrator_role_id'));

		if($administrator_role === null)
		{
			abort(403, 'This action is unauthorized.');
		}

        if($user->role->priority > $administrator_role->priority)
		{
			abort(403, 'This action is unauthorized.');
		}

		return $next($request);
	}
}
