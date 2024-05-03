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
            'role_id' => 1,
            'password' => Hash::make('123456')
        ]);
        
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'email' => 'admin@gmail.com',
            'role_id' => 2,
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Customer',
            'last_name' => 'Service',
            'email' => 'customerservice@gmail.com',
            'role_id' => 3,
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Accoutant',
            'last_name' => 'test',
            'email' => 'accoutant@gmail.com',
            'role_id' => 4,
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Inspection',
            'last_name' => 'Manager',
            'email' => 'inspection.manager@gmail.com',
            'role_id' => 5,
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Technician',
            'last_name' => 'Test',
            'email' => 'technician@gmail.com',
            'role_id' => 6,
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Satpal',
            'last_name' => 'Singh',
            'email' => 'customer@gmail.com',
            'role_id' => 7,
            'password' => Hash::make('123456')
        ]);
    }
}
