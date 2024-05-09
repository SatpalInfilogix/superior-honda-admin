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
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Cruisers']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Sportbikes']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Standard & Naked']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Adventure (ADV)']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Dual Sports & Enduros']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Dirtbikes']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Electric']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Choppers']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Touring']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Sport Touring']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Vintage & Customs']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Modern Classics']);
        VehicleTypeVehicleType::create(['category_id ' => '1', 'vehicle_type' => 'Commuters & Minis']);

        // Car Types
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'SUV']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Hatchback']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Crossover']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Convertible']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Sedan']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Sports Car']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Coupe']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Minivan']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Station Wagon']);
        VehicleTypeVehicleType::create(['category_id ' => '2', 'vehicle_type' => 'Pickup Truck']);
    }
}
