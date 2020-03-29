<?php

use Illuminate\Database\Seeder;
use Thtg88\MmCms\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        // Check if user exist
        $user = User::where('name', 'Admin Adminson')->first();
        if ($user === null) {
            // if not - create
            User::create([
                'name' => 'Admin Adminson',
                'email' => 'admin@domain.com',
                'password' => 'password',
                'role_id' => config('mmcms.roles.ids.default'),
            ]);
        }
    }
}
