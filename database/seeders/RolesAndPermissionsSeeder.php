<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view car']);
        Permission::create(['name' => 'create car']);
        Permission::create(['name' => 'edit car']);
        Permission::create(['name' => 'delete car']);
        

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('view user', 'create user', 'edit user', 'delete user', 'view car', 'create car', 'edit car', 'delete car');
 
        $role = Role::create(['name' => 'Customer Service'])
            ->givePermissionTo(['view user', 'create user']);
 
        $role = Role::create(['name' => 'Accountant'])
            ->givePermissionTo(['view user', 'create user']);
 
        $role = Role::create(['name' => 'Inspection Manager'])
            ->givePermissionTo(['view user', 'create user']);
 
        $role = Role::create(['name' => 'Technician'])
            ->givePermissionTo(['view user', 'create user']);

        $role = Role::create(['name' => 'Customer']);
    }
}
