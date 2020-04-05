<?php

namespace Thtg88\MmCms\Tests\Concerns\Get;

trait Test
{
    /**
     * Test successful get request.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGet()
    {
        $response = $this->get($this->getRoute());
        $response->assertStatus(200);
    }
}
