<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer Service']);
        Role::create(['name' => 'Accountant']);
        Role::create(['name' => 'Inspection Manager']);
        Role::create(['name' => 'Technician']);
        Role::create(['name' => 'Customer']);
    }
}
