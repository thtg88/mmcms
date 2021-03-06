<?php

namespace Thtg88\MmCms\Tests\Feature\Contracts;

interface ArchiveTest
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     */
    public function non_existing_model_authorization_errors();

    /**
     * Test an empty payload does not have any validation errors.
     *
     * @return void
     */
    public function empty_payload_has_no_errors(): void;

    /**
     * Test successful update.
     *
     * @return void
     */
    public function testSuccessfulArchive();

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function getRoute(array $parameters = []): string;
}
