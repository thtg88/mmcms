<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\Command;
use Thtg88\MmCms\Traits\Seedable;

class SeedCommand extends Command
{
    use Seedable;

    protected $seedersPath = __DIR__.DIRECTORY_SEPARATOR.'..'.
        DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
        'database'.DIRECTORY_SEPARATOR.'seeds'.DIRECTORY_SEPARATOR.'';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mmcms:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with data from the mmCMS package';

    /**
     * Execute the console command.
     *
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Seeding data into the database...');
        $this->seed('MmCmsDatabaseSeeder');
    }
}
