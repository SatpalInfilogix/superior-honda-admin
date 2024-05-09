<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterConfiguration;

class MasterConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuel_types = [
            "Petrol",
            "Diesel",
            "Electric"
        ];
        MasterConfiguration::create([
            'key' => 'fuel_types',
            'value' => json_encode($fuel_types)
        ]);
        
        $designations = [
            "Designation 1",
            "Designation 2",
        ];
        MasterConfiguration::create([
            'key' => 'designations',
            'value' => json_encode($designations)
        ]);
    }
}
