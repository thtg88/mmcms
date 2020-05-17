<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Traits\Seedable;

class MmCmsDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('ContentMigrationMethodsTableSeeder');
        $this->seed('ContentValidationRulesTableSeeder');
        $this->seed('ContentTypesTableSeeder');
        $this->seed('RolesTableSeeder');
        $this->seed('UsersTableSeeder');
    }
}
