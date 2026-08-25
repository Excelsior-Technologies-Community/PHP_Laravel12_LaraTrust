<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class ActivityLogSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $admin = $users->first();
        $manager = $users->skip(1)->first();

        $activities = [
            ['description' => 'created user', 'subject_type' => User::class, 'subject_id' => 2, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'updated user', 'subject_type' => User::class, 'subject_id' => 3, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'deleted user', 'subject_type' => User::class, 'subject_id' => 4, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'created role', 'subject_type' => Role::class, 'subject_id' => 2, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'updated role', 'subject_type' => Role::class, 'subject_id' => 3, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'created permission', 'subject_type' => Permission::class, 'subject_id' => 1, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'updated user status', 'subject_type' => User::class, 'subject_id' => 5, 'causer_type' => User::class, 'causer_id' => $manager?->id ?? 2],
            ['description' => 'created user', 'subject_type' => User::class, 'subject_id' => 6, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'bulk deleted users', 'subject_type' => null, 'subject_id' => null, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
            ['description' => 'updated user', 'subject_type' => User::class, 'subject_id' => 7, 'causer_type' => User::class, 'causer_id' => $manager?->id ?? 2],
            ['description' => 'created role', 'subject_type' => Role::class, 'subject_id' => 4, 'causer_type' => User::class, 'causer_id' => $admin?->id ?? 1],
        ];

        foreach ($activities as $index => $activityData) {
            Activity::create(array_merge($activityData, [
                'created_at' => now()->subDays(10 - $index)->subHours($index * 2),
                'updated_at' => now()->subDays(10 - $index)->subHours($index * 2),
            ]));
        }
    }
}
