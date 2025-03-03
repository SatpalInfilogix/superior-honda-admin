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

        Permission::create(['name' => 'view customer']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'edit customer']);
        Permission::create(['name' => 'delete customer']);

        Permission::create(['name' => 'view invoice']);
        Permission::create(['name' => 'create invoice']);
        Permission::create(['name' => 'edit invoice']);
        Permission::create(['name' => 'delete invoice']);

        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);

        Permission::create(['name' => 'view branch']);
        Permission::create(['name' => 'create branch']);
        Permission::create(['name' => 'edit branch']);
        Permission::create(['name' => 'delete branch']);

        Permission::create(['name' => 'view bay']);
        Permission::create(['name' => 'create bay']);
        Permission::create(['name' => 'edit bay']);
        Permission::create(['name' => 'delete bay']);

        Permission::create(['name' => 'view inquiry']);
        Permission::create(['name' => 'create inquiry']);
        Permission::create(['name' => 'edit inquiry']);
        Permission::create(['name' => 'delete inquiry']);

        Permission::create(['name' => 'view inspection']);
        Permission::create(['name' => 'create inspection']);
        Permission::create(['name' => 'edit inspection']);
        Permission::create(['name' => 'delete inspection']);

        Permission::create(['name' => 'view vehicle']);
        Permission::create(['name' => 'create vehicle']);
        Permission::create(['name' => 'edit vehicle']);
        Permission::create(['name' => 'delete vehicle']);

        Permission::create(['name' => 'view vehicle configuration']);
        Permission::create(['name' => 'create vehicle configuration']);
        Permission::create(['name' => 'edit vehicle configuration']);
        Permission::create(['name' => 'delete vehicle configuration']);

        Permission::create(['name' => 'view job']);
        Permission::create(['name' => 'create job']);
        Permission::create(['name' => 'edit job']);
        Permission::create(['name' => 'delete job']);

        Permission::create(['name' => 'view email template']);
        Permission::create(['name' => 'create email template']);
        Permission::create(['name' => 'edit email template']);
        Permission::create(['name' => 'delete email template']);

        Permission::create(['name' => 'view roles & permissions']);
        Permission::create(['name' => 'create roles & permissions']);
        Permission::create(['name' => 'edit roles & permissions']);
        Permission::create(['name' => 'delete roles & permissions']);

        Permission::create(['name' => 'view dashboard']);

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('view user', 'create user', 'edit user', 'delete user', 'view vehicle', 'create vehicle', 'edit vehicle', 'delete vehicle');
 
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
