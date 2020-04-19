<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $data = [
            [
                'name' => 'dev',
                'display_name' => 'Developer',
                'priority' => 1,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'priority' => 2,
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'priority' => 3,
            ],
        ];

        foreach ($data as $model_data) {
            // Check if dev role exist
            $role = Role::where('name', $model_data['name'])->first();

            // if not - create
            if ($role === null) {
                Role::create($model_data);
            }
        }
    }
}
