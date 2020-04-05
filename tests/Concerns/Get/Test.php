<?php

namespace Thtg88\MmCms\Tests\Concerns\Get;

trait Test
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get(): void
    {
        $response = $this->json('get', $this->getRoute());
        $response->assertStatus(200);
    }
}
