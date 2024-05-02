<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'Super Admin',
            'password' => Hash::make('123456')
        ]);

        VehicleCategory::factory()->create(['name' => 'Bike']);
        VehicleCategory::factory()->create(['name' => 'Car']);
    }
}
