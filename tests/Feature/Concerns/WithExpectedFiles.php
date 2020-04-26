<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns;

use Illuminate\Filesystem\Filesystem;

trait WithExpectedFiles
{
    /**
     * The files expected to have been created in the successful tests.
     *
     * @var array
     */
    protected $expected_files = [];

    public function assertExpectedFilesExist(): void
    {
        foreach ($this->expected_files as $_file) {
            $this->assertTrue(file_exists($_file));
        }
    }

    /**
     * Delete expected files.
     *
     * @return void
     */
    protected function deleteExpectedFiles(): void
    {
        if (count($this->expected_files) > 0) {
            app()->make(Filesystem::class)->delete($this->expected_files);
        }
    }

    protected function tearDown(): void
    {
        $this->deleteExpectedFiles();

        parent::tearDown();
    }
}
