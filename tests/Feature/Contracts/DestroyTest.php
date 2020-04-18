<?php

namespace Thtg88\MmCms\Tests\Feature\Contracts;

interface DestroyTest
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     */
    public function non_existing_model_authorization_errors();

    /**
     * Test successful destroy.
     *
     * @return void
     */
    public function successful_destroy();

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string;
}
