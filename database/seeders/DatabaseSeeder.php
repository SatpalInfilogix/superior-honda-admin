<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            VehicleCategorySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('123456')
        ]);
    }
}
