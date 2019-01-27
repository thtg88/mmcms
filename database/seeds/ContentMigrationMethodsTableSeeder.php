<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Models\ContentMigrationMethod;

class ContentMigrationMethodsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'boolean')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'boolean',
                'display_name' => 'Boolean',
            ]);
        }

        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'dateTime')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'dateTime',
                'display_name' => 'Date Time',
            ]);
        }

        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'decimal')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'decimal',
                'display_name' => 'Decimal',
            ]);
        }

        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'string')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'string',
                'display_name' => 'String',
            ]);
        }

        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'text')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'text',
                'display_name' => 'Text',
            ]);
        }

        // Check if resource exist
        $resource = ContentMigrationMethod::where('name', 'unsignedInteger')->first();

        if($resource === null)
        {
            // if not - create
            ContentMigrationMethod::create([
                'name' => 'unsignedInteger',
                'display_name' => 'Unsigned Integer',
            ]);
        }
    }
}
