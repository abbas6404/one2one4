<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Enable these options if you need same role and other permission for User Model
         * Else, please follow the below steps for admin guard
         */

        // Create Roles and Permissions
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleEditor = Role::create(['name' => 'editor']);
        // $roleUser = Role::create(['name' => 'user']);


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'blog',
                'permissions' => [
                    // Blog Permissions
                    'blog.create',
                    'blog.view',
                    'blog.edit',
                    'blog.delete',
                    'blog.approve',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                    'profile.delete',
                    'profile.update',
                ]
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // user Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                ]
            ],
            [
                'group_name' => 'location',
                'permissions' => [
                    'location.view',
                    'location.create',
                    'location.edit',
                    'location.delete',
                ]
            ],
            [
                'group_name' => 'website',
                'permissions' => [
                    'website.content.view',
                    'website.content.create',
                    'website.content.edit',
                    'website.content.delete',
                ]
            ],
            [
                'group_name' => 'blood_request',
                'permissions' => [
                    'blood.request.create',
                    'blood.request.view',
                    'blood.request.edit',
                    'blood.request.delete',
                    'blood.request.approve',
                    'blood.request.reject',
                ]
            ],
            [
                'group_name' => 'blood_donation',
                'permissions' => [
                    'blood.donation.create',
                    'blood.donation.view',
                    'blood.donation.edit',
                    'blood.donation.delete',
                    'blood.donation.approve',
                    'blood.donation.reject',
                ]
            ],
            [
                'group_name' => 'gallery',
                'permissions' => [
                    // Gallery Management Permissions
                    'gallery.view',
                    'gallery.create',
                    'gallery.edit',
                    'gallery.delete',
                    // Gallery Category Permissions
                    'gallery.category.view',
                    'gallery.category.create',
                    'gallery.category.edit',
                    'gallery.category.delete',
                ]
            ],
            [
                'group_name' => 'testimonial',
                'permissions' => [
                    // Testimonial Management Permissions
                    'testimonial.view',
                    'testimonial.create',
                    'testimonial.edit',
                    'testimonial.delete',
                ]
            ],
            [
                'group_name' => 'sponsor',
                'permissions' => [
                    // Sponsor Management Permissions
                    'sponsor.view',
                    'sponsor.create',
                    'sponsor.edit',
                    'sponsor.delete',
                ]
            ],
            [
                'group_name' => 'event',
                'permissions' => [
                    // Event Management Permissions
                    'event.view',
                    'event.create',
                    'event.edit',
                    'event.delete',
                ]
            ],
            [
                'group_name' => 'internal_program',
                'permissions' => [
                    // Internal Program Management Permissions
                    'internal.program.view',
                    'internal.program.create',
                    'internal.program.edit',
                ]
            ],
            
            [
                'group_name' => 'contact',
                'permissions' => [
                    // Contact Message Management Permissions
                    'contact.view',
                    'contact.update',
                    'contact.delete',
                ]
            ],
            
            
            
            

            

        ];


        // Create and Assign Permissions
        // for ($i = 0; $i < count($permissions); $i++) {
        //     $permissionGroup = $permissions[$i]['group_name'];
        //     for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
        //         // Create Permission
        //         $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
        //         $roleSuperAdmin->givePermissionTo($permission);
        //         $permission->assignRole($roleSuperAdmin);
        //     }
        // }

        // Do same for the admin guard for tutorial purposes.
        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permissionExist = Permission::where('name', $permissions[$i]['permissions'][$j])->first();
                if (is_null($permissionExist)) {
                    $permission = Permission::create(
                        [
                            'name' => $permissions[$i]['permissions'][$j],
                            'group_name' => $permissionGroup,
                            'guard_name' => 'admin'
                        ]
                    );
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        // Assign super admin role permission to superadmin user
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }

        $this->command->info('Roles and Permissions created successfully!');
    }

    private function maybeCreateSuperAdminRole($admin): Role
    {
        if (is_null($admin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        }

        if (is_null($roleSuperAdmin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        }

        return $roleSuperAdmin;
    }
}
