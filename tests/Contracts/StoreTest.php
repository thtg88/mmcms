<?php

namespace Thtg88\MmCms\Tests\Contracts;

interface StoreTest
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     */
    public function empty_payload_has_required_validation_errors();

    /**
     * Test successful store.
     *
     * @return void
     */
    public function successful_store();

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string;
}
