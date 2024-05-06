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
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Super Admin');
        
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Admin');

        $user = User::create([
            'first_name' => 'Customer',
            'last_name' => 'Service',
            'email' => 'customerservice@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Customer Service');

        $user = User::create([
            'first_name' => 'Accoutant',
            'last_name' => 'test',
            'email' => 'accoutant@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Accountant');

        $user = User::create([
            'first_name' => 'Inspection',
            'last_name' => 'Manager',
            'email' => 'inspection.manager@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Inspection Manager');

        $user = User::create([
            'first_name' => 'Technician',
            'last_name' => 'Test',
            'email' => 'technician@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Technician');

        $user = User::create([
            'first_name' => 'Satpal',
            'last_name' => 'Singh',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Customer');
    }
}
