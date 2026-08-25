<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // ROLES
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'slug' => 'admin'
        ], [
            'display_name' => 'Administrator',
            'description' => 'Full system access'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'Manager',
            'slug' => 'manager'
        ], [
            'display_name' => 'Manager',
            'description' => 'Manage users and content'
        ]);

        $editorRole = Role::firstOrCreate([
            'name' => 'Editor',
            'slug' => 'editor'
        ], [
            'display_name' => 'Editor',
            'description' => 'Edit content'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'User',
            'slug' => 'user'
        ], [
            'display_name' => 'User',
            'description' => 'Regular user'
        ]);

        // PERMISSIONS
        $permissions = [
            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'description' => 'Create, edit, delete users'],
            ['name' => 'manage-roles', 'display_name' => 'Manage Roles', 'description' => 'Create, edit, delete roles'],
            ['name' => 'manage-permissions', 'display_name' => 'Manage Permissions', 'description' => 'Create, edit, delete permissions'],
            ['name' => 'view-dashboard', 'display_name' => 'View Dashboard', 'description' => 'Access dashboard'],
            ['name' => 'edit-content', 'display_name' => 'Edit Content', 'description' => 'Edit website content'],
            ['name' => 'publish-content', 'display_name' => 'Publish Content', 'description' => 'Publish content to website'],
            ['name' => 'view-reports', 'display_name' => 'View Reports', 'description' => 'View analytics reports'],
        ];

        $permissionModels = [];
        foreach ($permissions as $perm) {
            $permissionModels[$perm['name']] = Permission::firstOrCreate(
                ['name' => $perm['name']],
                $perm
            );
        }

        // ASSIGN PERMISSIONS TO ROLES
        $adminRole->permissions()->sync(array_column($permissionModels, 'id'));

        $managerRole->permissions()->sync([
            $permissionModels['manage-users']->id,
            $permissionModels['view-dashboard']->id,
            $permissionModels['view-reports']->id,
            $permissionModels['edit-content']->id,
        ]);

        $editorRole->permissions()->sync([
            $permissionModels['edit-content']->id,
            $permissionModels['publish-content']->id,
            $permissionModels['view-dashboard']->id,
        ]);

        $userRole->permissions()->sync([
            $permissionModels['view-dashboard']->id,
        ]);

        // USERS
        $users = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Amit Shah',
                'email' => 'amit@example.com',
                'password' => bcrypt('password123'),
                'status' => 'inactive',
            ],
            [
                'name' => 'Neha Gupta',
                'email' => 'neha@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram@example.com',
                'password' => bcrypt('password123'),
                'status' => 'banned',
            ],
            [
                'name' => 'Anjali Mehta',
                'email' => 'anjali@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Suresh Joshi',
                'email' => 'suresh@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Kavita Reddy',
                'email' => 'kavita@example.com',
                'password' => bcrypt('password123'),
                'status' => 'inactive',
            ],
            [
                'name' => 'Rahul Verma',
                'email' => 'rahul@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'Pooja Sharma',
                'email' => 'pooja@example.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // ASSIGN ROLES TO USERS
        $createdUsers[0]->syncRoles([$adminRole->id]); // Rajesh - Admin
        $createdUsers[1]->syncRoles([$managerRole->id]); // Priya - Manager
        $createdUsers[2]->syncRoles([$editorRole->id]); // Amit - Editor
        $createdUsers[3]->syncRoles([$userRole->id]); // Neha - User
        $createdUsers[4]->syncRoles([$userRole->id]); // Vikram - User (Banned)
        $createdUsers[5]->syncRoles([$editorRole->id]); // Anjali - Editor
        $createdUsers[6]->syncRoles([$managerRole->id]); // Suresh - Manager
        $createdUsers[7]->syncRoles([$userRole->id]); // Kavita - User (Inactive)
        $createdUsers[8]->syncRoles([$adminRole->id]); // Rahul - Admin
        $createdUsers[9]->syncRoles([$userRole->id]); // Pooja - User

        // LOGIN HISTORIES
        $loginHistories = [
            ['email' => 'rajesh@example.com', 'ip_address' => '192.168.1.10', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0', 'logged_in_at' => now()->subDays(5), 'logged_out_at' => null],
            ['email' => 'priya@example.com', 'ip_address' => '192.168.1.15', 'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36', 'logged_in_at' => now()->subDays(3), 'logged_out_at' => now()->subDays(3)->addHours(2)],
            ['email' => 'amit@example.com', 'ip_address' => '192.168.1.20', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0', 'logged_in_at' => now()->subDays(2), 'logged_out_at' => null],
            ['email' => 'neha@example.com', 'ip_address' => '192.168.1.25', 'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15', 'logged_in_at' => now()->subDay(), 'logged_out_at' => now()->subDay()->addMinutes(30)],
            ['email' => 'rajesh@example.com', 'ip_address' => '192.168.1.10', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0', 'logged_in_at' => now()->subHours(5), 'logged_out_at' => null],
            ['email' => 'rahul@example.com', 'ip_address' => '192.168.1.30', 'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0', 'logged_in_at' => now()->subHours(3), 'logged_out_at' => null],
            ['email' => 'pooja@example.com', 'ip_address' => '192.168.1.35', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Edge/120.0', 'logged_in_at' => now()->subHours(1), 'logged_out_at' => null],
            ['email' => 'suresh@example.com', 'ip_address' => '192.168.1.40', 'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/120.0', 'logged_in_at' => now()->subDays(4), 'logged_out_at' => now()->subDays(4)->addHour()],
        ];

        foreach ($loginHistories as $history) {
            $user = User::where('email', $history['email'])->first();
            if ($user) {
                LoginHistory::create([
                    'user_id' => $user->id,
                    'email' => $history['email'],
                    'ip_address' => $history['ip_address'],
                    'user_agent' => $history['user_agent'],
                    'logged_in_at' => $history['logged_in_at'],
                    'logged_out_at' => $history['logged_out_at'],
                ]);
            }
        }
    }
}
