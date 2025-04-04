<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
            RolesAndPermissionsSeeder::class,
            LocationSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            VehicleCategorySeeder::class,
            MasterConfigurationSeeder::class,
            VehicleTypeSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
