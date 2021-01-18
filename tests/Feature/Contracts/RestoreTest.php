<?php

namespace Thtg88\MmCms\Tests\Feature\Contracts;

interface RestoreTest
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     */
    public function non_existing_model_authorization_errors();

    /**
     * Test successful restore.
     *
     * @return void
     */
    public function successful_restore();

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function getRoute(array $parameters = []): string;
}
