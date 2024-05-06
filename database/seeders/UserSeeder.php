<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Super Admin');
        
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Admin');

        User::create([
            'first_name' => 'Customer',
            'last_name' => 'Service',
            'email' => 'customerservice@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Customer Service');

        User::create([
            'first_name' => 'Accoutant',
            'last_name' => 'test',
            'email' => 'accoutant@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Accountant');

        User::create([
            'first_name' => 'Inspection',
            'last_name' => 'Manager',
            'email' => 'inspection.manager@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Inspection Manager');

        User::create([
            'first_name' => 'Technician',
            'last_name' => 'Test',
            'email' => 'technician@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Technician');

        User::create([
            'first_name' => 'Satpal',
            'last_name' => 'Singh',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('123456')
        ])->assignRole('Customer');
    }
}
