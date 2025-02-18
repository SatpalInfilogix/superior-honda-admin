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
        Module::updateOrCreate([
            'name' => 'Invoice',
            'slug' => 'invoice'
        ]);
        Module::updateOrCreate([
            'name' => 'Product',
            'slug' => 'product'
        ]);
        Module::updateOrCreate([
            'name' => 'Order',
            'slug' => 'Order'
        ]);
        Module::updateOrCreate([
            'name' => 'User',
            'slug' => 'user'
        ]);
        Module::updateOrCreate([
            'name' => 'Customer',
            'slug' => 'customer'
        ]);
        Module::updateOrCreate([
            'name' => 'Product',
            'slug' => 'product'
        ]);
        Module::updateOrCreate([
            'name' => 'Vehicle',
            'slug' => 'vehicle'
        ]);
        Module::updateOrCreate([
            'name' => 'Vehicle Configuration',
            'slug' => 'vehicle configuration'
        ]);
        Module::updateOrCreate([
            'name' => 'Branch',
            'slug' => 'branch'
        ]);
        Module::updateOrCreate([
            'name' => 'Location',
            'slug' => 'location'
        ]);
        Module::updateOrCreate([
            'name' => 'Bay',
            'slug' => 'bay'
        ]);
        Module::updateOrCreate([
            'name' => 'Inquiry',
            'slug' => 'inquiry'
        ]);
        Module::updateOrCreate([
            'name' => 'Inspection',
            'slug' => 'inspection'
        ]);
        Module::updateOrCreate([
            'name' => 'Job',
            'slug' => 'job'
        ]);
        Module::updateOrCreate([
            'name' => 'Email Template',
            'slug' => 'email template'
        ]);
        Module::updateOrCreate([
            'name' => 'Roles & Permissions',
            'slug' => 'roles & permissions'
        ]);
        Module::updateOrCreate([
            'name' => 'Customer Inquiry',
            'slug' => 'customer inquiry'
        ]);
        Module::updateOrCreate([
            'name' => 'Promotions',
            'slug' => 'promotions'
        ]);
        Module::updateOrCreate([
            'name' => 'Coupons',
            'slug' => 'coupons'
        ]);
        Module::updateOrCreate([
            'name' => 'Reports',
            'slug' => 'reports'
        ]);
        Module::updateOrCreate([
            'name' => 'Cart',
            'slug' => 'cart'
        ]);
        Module::updateOrCreate([
            'name' => 'Banners',
            'slug' => 'banners'
        ]);
        Module::updateOrCreate([
            'name' => 'Sales Products',
            'slug' => 'sales-products'
        ]);
        Module::updateOrCreate([
            'name' => 'Services',
            'slug' => 'services'
        ]);
        Module::updateOrCreate([
            'name' => 'Testimonials',
            'slug' => 'testimonials'
        ]);
        Module::updateOrCreate([
            'name' => 'Settings',
            'slug' => 'settings'
        ]);
        Module::updateOrCreate([
            'name' => 'FAQs',
            'slug' => 'faqs'
        ]);
    }
}
