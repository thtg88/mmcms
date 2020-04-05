<?php

namespace Thtg88\MmCms\Tests\Contracts;

interface StoreTest
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     */
    public function testEmptyPayloadHasRequiredValidationErrors();

    /**
     * Test successful store.
     *
     * @return void
     */
    public function testSuccessfulStore();

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string;
}
