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
        $roles = Role::get();

        $permissions = [
            'users' => ['view', 'create', 'update', 'delete'],
            'customers' => ['view', 'create', 'update', 'delete'],
            'cars' => ['view', 'create', 'update', 'delete'],
            'branches' => ['view', 'create', 'update', 'delete'],
            'inquiries' => ['view', 'create', 'update', 'delete'],
            'inspection' => ['view', 'create', 'update', 'delete'],
            'jobs' => ['view', 'create', 'update', 'delete'],
            'invoices' => ['view', 'create', 'update', 'delete'],
            'products' => ['view', 'create', 'update', 'delete'],
            'services' => ['view', 'create', 'update', 'delete'],
            'towing request' => ['view', 'create', 'update', 'delete'],
            'orders' => ['view', 'create', 'update', 'delete'],
            'copons' => ['view', 'create', 'update', 'delete'],
            'payments' => ['view', 'create', 'update', 'delete'],
            'email templates' => ['view', 'create', 'update', 'delete'],
        ];

        foreach ($permissions as $entity => $entityPermissions) {
            foreach ($entityPermissions as $permission) {
                $permissionName = $entity . '.' . $permission;
                Permission::create(['name' => $permissionName]);

                foreach ($roles as $role) {
                    Role::where('name', $role->name)->first()->assignPermission($permissionName);
                }
            }
        }
    }
}
