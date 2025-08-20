<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create simple permissions
        $permissions = [
            'read',   // user can only read
            'write', // user can create, update, delete
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $recruiter = Role::firstOrCreate(['name' => 'recruiter']);

        // 3. Assign permissions
        $admin->syncPermissions(['write']);
        $manager->syncPermissions(['write']);
        $recruiter->syncPermissions(['read']);
    }
}