<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            'Super Admin',
            'Admin',
            'Customer Service',
            'Accountant',
            'Inspection Manager',
            'Technician'
        ];

        // Define permissions for CRUD operations on each entity
        $permissions = [
            'users' => ['view user', 'create user', 'update user', 'delete user'],
            'customers' => ['view customer', 'create customer', 'update customer', 'delete customer'],
            'cars' => ['view car', 'create car', 'update car', 'delete car'],
            'branches' => ['view branch', 'create branch', 'update branch', 'delete branch'],
            'inquiries' => ['view inquiry', 'create inquiry', 'update inquiry', 'delete inquiry'],
        ];

        // Create permissions and assign them to roles
        foreach ($permissions as $entity => $entityPermissions) {
            foreach ($entityPermissions as $permission) {
                $permissionName = $entity . '.' . $permission;
                Permission::create(['name' => $permissionName]);

                foreach ($roles as $role) {
                    Role::where('name', $role)->first()->assignPermission($permissionName);
                }
            }
        }
    }
}
