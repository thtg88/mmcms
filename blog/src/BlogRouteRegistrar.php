<?php

namespace Thtg88\MmCms\Blog;

use Illuminate\Contracts\Routing\Registrar as Router;

class BlogRouteRegistrar
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
     * @param \Illuminate\Contracts\Routing\Registrar  $router
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
        $this->router->group(['middleware' => ['web', 'auth']], function ($router) {
            $router->get('/authorize', [
                'uses' => 'AuthorizationController@authorize',
            ]);
        });

        $this->router->post('/token', [
            'uses' => 'AccessTokenController@issueToken',
            'middleware' => 'throttle',
        ]);
    }
}
