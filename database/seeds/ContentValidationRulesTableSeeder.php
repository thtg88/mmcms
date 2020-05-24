<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Models\ContentValidationRule;

class ContentValidationRulesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $data = [
            ['name' => 'required'],
            ['name' => 'nullable'],
            ['name' => 'boolean'],
            ['name' => 'date'],
            ['name' => 'numeric'],
            ['name' => 'integer'],
            ['name' => 'string'],
            ['name' => 'text'],
            ['name' => 'min:1'],
            ['name' => 'max:255'],
            ['name' => 'max:65535'],
        ];

        foreach ($data as $model_data) {
            // Check if resource exist
            $resource = ContentValidationRule::where(
                'name',
                $model_data['name']
            )->first();

            // if not - create
            if ($resource === null) {
                ContentValidationRule::create($model_data);
            }
        }
    }
}
