<?php

namespace Thtg88\MmCms\Http\Controllers\Concerns;

use Illuminate\Container\Container;

/**
 * Add bindings functionality to controllers.
 */
trait WithBindings
{
    /**
     * The controller-specific bindings.
     *
     * @var callable[]|string[]
     */
    protected $bindings = [];

    /**
     * Add controller specific bindings.
     *
     * @return void
     */
    protected function addBindings()
    {
        $app = Container::getInstance();

        foreach ($this->getBindings() as $abstract => $concrete) {
            $app->bind($abstract, $concrete);
        }
    }

    /**
     * Return the controller bindings.
     *
     * @return callable[]|string[]
     */
    protected function getBindings()
    {
        return $this->bindings;
    }
}
