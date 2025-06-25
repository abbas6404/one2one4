<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create admin
        $admin = Admin::where('email', 'admin@gmail.com')->first();
        
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => '12345678', // Password will be automatically hashed by the model
            ]);
        } else {
            $admin->update([
                'password' => '12345678'
            ]);
        }

        // Create roles and permissions
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
        
        // Define permissions
        $permissions = [
            'dashboard.view',
            'admin.create',
            'admin.view',
            'admin.edit',
            'admin.delete',
            'role.create',
            'role.view',
            'role.edit',
            'role.delete',
            'user.create',
            'user.view',
            'user.edit',
            'user.delete'
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Assign all permissions to the role
        $role->syncPermissions($permissions);

        // Assign role to admin
        if (!$admin->hasRole('Super Admin')) {
            $admin->assignRole($role);
        }

        // Run factory to create additional admins with unique details.
        Admin::factory()->count(10)->create();
        $this->command->info('Admins table seeded with 11 admins!');
    }
}
