<?php

namespace Thtg88\MmCms;

use Illuminate\Support\Facades\Route;

class MmCms
{
    /**
     * Binds the mmCMS routes into the controller.
     *
     * @param  array  $options
     * @return void
     */
    public static function routes(array $options = [])
    {
        $callback = function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'v1',
            'namespace' => '\Thtg88\MmCms\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
