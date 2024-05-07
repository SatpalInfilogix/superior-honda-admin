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
            'name' => 'Manage Products',
            'slug' => 'manage products'
        ]);
        Module::create([
            'name' => 'Manage Order',
            'slug' => 'manage Order'
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
            'name' => 'Order',
            'slug' => 'order'
        ]);
        Module::create([
            'name' => 'Car',
            'slug' => 'car'
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
    }
}
