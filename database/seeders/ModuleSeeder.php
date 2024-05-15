<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create([
            'name' => 'Invoice',
            'slug' => 'invoice'
        ]);
        Module::create([
            'name' => 'Product',
            'slug' => 'product'
        ]);
        Module::create([
            'name' => 'Order',
            'slug' => 'Order'
        ]);
        Module::create([
            'name' => 'User',
            'slug' => 'user'
        ]);
        Module::create([
            'name' => 'Customer',
            'slug' => 'customer'
        ]);
        Module::create([
            'name' => 'Product',
            'slug' => 'product'
        ]);
        Module::create([
            'name' => 'Vehicle',
            'slug' => 'vehicle'
        ]);
        Module::create([
            'name' => 'Vehicle Configuration',
            'slug' => 'vehicle configuration'
        ]);
        Module::create([
            'name' => 'Branch',
            'slug' => 'branch'
        ]);
        Module::create([
            'name' => 'Inquiry',
            'slug' => 'inquiry'
        ]);
        Module::create([
            'name' => 'Job',
            'slug' => 'job'
        ]);
        Module::create([
            'name' => 'Email Template',
            'slug' => 'email template'
        ]);
        Module::create([
            'name' => 'Roles & Permissions',
            'slug' => 'roles & permissions'
        ]);
    }
}
