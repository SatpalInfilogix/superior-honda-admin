<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bike Types
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Cruisers']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Sportbikes']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Standard & Naked']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Adventure (ADV)']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Dual Sports & Enduros']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Dirtbikes']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Electric']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Choppers']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Touring']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Sport Touring']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Vintage & Customs']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Modern Classics']);
        VehicleType::create(['category_id' => '1', 'vehicle_type' => 'Commuters & Minis']);

        // Car Types
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'SUV']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Hatchback']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Crossover']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Convertible']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Sedan']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Sports Car']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Coupe']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Minivan']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Station Wagon']);
        VehicleType::create(['category_id' => '2', 'vehicle_type' => 'Pickup Truck']);
    }
}
