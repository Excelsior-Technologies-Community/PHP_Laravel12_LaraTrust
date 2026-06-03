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
        // ROLES
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'User',
            'slug' => 'user'
        ]);

        // PERMISSION
        $createPost = Permission::firstOrCreate([
            'name' => 'create-post'
        ], [
            'display_name' => 'Create Post',
            'description' => 'Create Post Permission'
        ]);

        // ASSIGN PERMISSION TO ROLE
        $adminRole->permissions()->syncWithoutDetaching([$createPost->id]);

        // USER
        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('123456')
        ]);

        // ASSIGN ROLE (Laratrust correct way)
        $adminUser->syncRoles([$adminRole->id]);
    }
}