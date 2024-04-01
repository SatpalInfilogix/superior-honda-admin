<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
            ]
        ];

        foreach($admins as $admin) {
            $user = User::where('email', $admin['email'])->first();
            if (!$user) {
                User::create([
                    'name'      => $admin['name'],
                    'email'     => $admin['email'],
                    'password'  => $admin['password'],
                ]);
            }
        }
    }
}
