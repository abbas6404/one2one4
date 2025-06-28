<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EventPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define event permissions
        $eventPermissions = [
            'event.view',
            'event.create',
            'event.edit',
            'event.delete',
        ];

        // Create permissions if they don't exist
        foreach ($eventPermissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'admin',
                'group_name' => 'event'
            ]);
        }

        // Get or create a role (you can change 'Editor' to any role you want)
        $role = Role::firstOrCreate([
            'name' => 'Event Manager',
            'guard_name' => 'admin'
        ]);

        // Assign event permissions to the role
        $role->syncPermissions($eventPermissions);

        $this->command->info('Event permissions assigned to Event Manager role successfully!');
    }
} 