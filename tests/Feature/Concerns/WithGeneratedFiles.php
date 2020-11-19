<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

trait WithGeneratedFiles
{
    /**
     * The files expected to have been created in the successful tests.
     *
     * @var array
     */
    protected $generated_files = [];

    public function assertGeneratedFilesExist(): void
    {
        foreach ($this->generated_files as $_file) {
            $this->assertFileExists($_file);
        }
    }

    /**
     * Delete expected files.
     *
     * @return void
     */
    protected function deleteGeneratedFiles(): void
    {
        if (count($this->generated_files) > 0) {
            app()->make(Filesystem::class)->delete($this->generated_files);
        }
    }

    protected function tearDown(): void
    {
        $this->deleteGeneratedFiles();

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
