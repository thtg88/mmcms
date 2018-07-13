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
        // Check if dev role exist
        $role = Role::where('name', 'developer')->first();
        if($role === null)
        {
            // if not - create
            Role::create([
                'name' => 'dev',
                'display_name' => 'Developer',
                'priority' => 1,
            ]);
        }

        // Check if admin role exist
        $role = Role::where('name', 'admin')->first();
        if($role === null)
        {
            // if not - create
            Role::create([
                'name' => 'admin',
                'display_name' => 'Administrator',
                'priority' => 2,
            ]);
        }

        // Check if user role exist
        $role = Role::where('name', 'user')->first();
        if($role === null)
        {
            // if not - create
            Role::create([
                'name' => 'user',
                'display_name' => 'User',
                'priority' => 3,
            ]);
        }
    }
}
