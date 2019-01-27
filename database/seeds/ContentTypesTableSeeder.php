<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentType;

class ContentTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        // Check if resource exist
        $resource = ContentType::where('name', 'Text')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'string')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Text',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => 'Use for titles, names, tags, URLs, e-mail addresses',
                    'priority' => 1,
                ]);
            }
        }

        // Check if resource exist
        $resource = ContentType::where('name', 'Long Text')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'text')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Long Text',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => 'Use for descriptions, text paragraphs, articles',
                    'priority' => 2,
                ]);
            }
        }

        // Check if resource exist
        $resource = ContentType::where('name', 'Integer Positive Number')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'unsignedInteger')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Integer Positive Number',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => '1, 2, 3, 5, 8, 13, ...',
                    'priority' => 3,
                ]);
            }
        }

        // Check if resource exist
        $resource = ContentType::where('name', 'Decimal Number')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'decimal')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Decimal Number',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => '3.14159265389',
                    'priority' => 4,
                ]);
            }
        }

        // Check if resource exist
        $resource = ContentType::where('name', 'Date and Time')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'dateTime')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Date and Time',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => 'Event date, opening hours',
                    'priority' => 5,
                ]);
            }
        }

        // Check if resource exist
        $resource = ContentType::where('name', 'Boolean')->first();

        if($resource === null)
        {
            // Get migration method
            $migration_method = ContentMigrationMethod::where('name', 'boolean')->first();

            if($migration_method !== null)
            {
                // if not - create
                ContentType::create([
                    'name' => 'Boolean',
                    'content_migration_method_id' => $migration_method->id,
                    'description' => 'Yes or no, 1 or 0, true or false',
                    'priority' => 6,
                ]);
            }
        }
    }
}
