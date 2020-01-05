<?php

namespace Thtg88\MmCms\Blog;

class BlogModule
{
    /**
     * Binds the mmCMS routes into the controller.
     *
     * @param array  $options
     * @return void
     */
    public static function routes(array $options = [])
    {
        $callback = function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'blog',
            'namespace' => '\Thtg88\MmCms\Blog\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new BlogRouteRegistrar($router));
        });
    }
}
