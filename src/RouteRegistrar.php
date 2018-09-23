<?php

namespace Thtg88\MmCms;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forAuth();
        $this->forRoles();
        $this->forUsers();
    }

    public function forAuth()
    {
        // Auth routes...
        $this->router->post('auth/register', [
            'uses' => 'AuthController@register',
            'as' => 'register'
        ]);
        $this->router->post('auth/login', [
            'uses' => 'AuthController@login',
            'as' => 'login'
        ]);

        $this->router->group(['middleware' => 'auth:api'], function($router) {
            $router->delete('auth/logout', [
                'uses' => 'AuthController@logout',
                'as' => 'logout'
            ]);
            $router->get('auth/me', [
                'uses' => 'AuthController@me',
                'as' => 'me'
            ]);
            $router->put('auth/me', [
                'uses' => 'AuthController@updateProfile',
                'as' => 'update-profile'
            ]);
        });
    }

    public function forRoles()
    {
        $this->router->group(['as' => 'mmcms.roles.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('roles', [
                    'uses' => 'RoleController@index',
                    'as' => 'index'
                ]);
                $router->get('roles/paginate', [
                    'uses' => 'RoleController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('roles/{id}', [
                    'uses' => 'RoleController@show',
                    'as' => 'show'
                ]);
                $router->post('roles', [
                    'uses' => 'RoleController@store',
                    'as' => 'store'
                ]);
                $router->put('roles/{id}', [
                    'uses' => 'RoleController@update',
                    'as' => 'update'
                ]);
                $router->delete('roles/{id}', [
                    'uses' => 'RoleController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forUsers()
    {
        $this->router->group(['as' => 'mmcms.users.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // User routes...
                $router->get('users', [
                    'uses' => 'UserController@index',
                    'as' => 'index'
                ]);
                $router->get('users/paginate', [
                    'uses' => 'UserController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('users/{id}', [
                    'uses' => 'UserController@show',
                    'as' => 'show'
                ]);
                $router->post('users', [
                    'uses' => 'UserController@store',
                    'as' => 'store'
                ]);
                $router->put('users/{id}', [
                    'uses' => 'UserController@update',
                    'as' => 'update'
                ]);
                $router->delete('users/{id}', [
                    'uses' => 'UserController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }
}
