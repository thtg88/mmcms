<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

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

    /**
     * Return the lines output by the console in an array, one line per item.
     *
     * @return array
     */
    protected function getConsoleOutputLines(): array
    {
        return explode(DIRECTORY_SEPARATOR, Artisan::output());
    }

    /**
     * Return the migrating migration, as output by the console.
     *
     * @return string
     */
    protected function getMigratingMigration(): string
    {
        return str_replace(
            'Migrating: ',
            '',
            $this->getConsoleOutputLines()[0]
        );
    }

    /**
     * Return the latest migrating migration timestamp.
     *
     * @return string
     */
    protected function getLatestMigratingMigrationTimestamp(): string
    {
        return implode('_', array_slice(
            explode('_', $this->getMigratingMigration()),
            0,
            4
        ));
    }
}
