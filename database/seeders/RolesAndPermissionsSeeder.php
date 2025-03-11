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

        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'edit services']);
        Permission::create(['name' => 'create services']);
        Permission::create(['name' => 'delete services']);


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

        Permission::create(['name' => 'view location']);
        Permission::create(['name' => 'edit location']);
        Permission::create(['name' => 'create location']);
        Permission::create(['name' => 'delete location']);

        Permission::create(['name' => 'view bay']);
        Permission::create(['name' => 'create bay']);
        Permission::create(['name' => 'edit bay']);
        Permission::create(['name' => 'delete bay']);

        Permission::create(['name' => 'view promotions']);
        Permission::create(['name' => 'edit promotions']);
        Permission::create(['name' => 'create promotions']);
        Permission::create(['name' => 'delete promotions']);

        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'edit reports']);
        Permission::create(['name' => 'create reports']);
        Permission::create(['name' => 'delete reports']);

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

        Permission::create(['name' => 'view faqs']);
        Permission::create(['name' => 'edit faqs']);
        Permission::create(['name' => 'create faqs']);
        Permission::create(['name' => 'delete faqs']);

        Permission::create(['name' => 'view testimonials']);
        Permission::create(['name' => 'create testimonials']);
        Permission::create(['name' => 'edit testimonials']);
        Permission::create(['name' => 'delete testimonials']);

        Permission::create(['name' => 'view email template']);
        Permission::create(['name' => 'create email template']);
        Permission::create(['name' => 'edit email template']);
        Permission::create(['name' => 'delete email template']);

        Permission::create(['name' => 'view roles & permissions']);
        Permission::create(['name' => 'create roles & permissions']);
        Permission::create(['name' => 'edit roles & permissions']);
        Permission::create(['name' => 'delete roles & permissions']);

        Permission::create(['name' => 'view dashboard']);

        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'create settings']);
        Permission::create(['name' => 'delete settings']);

        Permission::create(['name' => 'view customer inquiry']);
        Permission::create(['name' => 'create customer inquiry']);
        Permission::create(['name' => 'edit customer inquiry']);
        Permission::create(['name' => 'delete customer inquiry']);

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
