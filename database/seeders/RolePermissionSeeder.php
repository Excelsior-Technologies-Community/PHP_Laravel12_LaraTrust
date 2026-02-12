<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole =Role::create([
    'name' => 'Admin',
    'slug' => 'admin'
]);
       

        $userRole = Role::create([
    'name' => 'Admin',
    'slug' => 'admin'
]);

        // Create Permission
        $createPost = Permission::create([
            'name' => 'create-post',
            'display_name' => 'Create Post',
            'description' => 'Create Post Permission'
        ]);

        $adminRole->attachPermission($createPost);

        // Create Admin User
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $user->attachRole($adminRole);
    }

    
}
