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
        $data = [
            ['name' => 'boolean', 'display_name' => 'Boolean'],
            ['name' => 'dateTime', 'display_name' => 'Date Time'],
            ['name' => 'decimal', 'display_name' => 'Decimal'],
            ['name' => 'string', 'display_name' => 'String'],
            ['name' => 'text', 'display_name' => 'Text'],
            ['name' => 'unsignedInteger', 'display_name' => 'Unsigned Integer'],
        ];

        foreach ($data as $model_data) {
            // Check if resource exist
            $resource = ContentMigrationMethod::where(
                'name',
                $model_data['name']
            )->first();

            // if not - create
            if ($resource === null) {
                ContentMigrationMethod::create($model_data);
            }
        }
    }
}
