<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\BranchLocations;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create(['name' => 'Kingston Branch', 'unique_code' => 'BR0001', 'address' => 'Kingston', 'pincode' => 'JMAKN01', 'status' => 'Working']);
        Branch::create(['name' => 'Ocho Rios Branch', 'unique_code' => 'BR0002', 'address' => 'Ocho Rios', 'pincode' => 'JMCAN19', 'status' => 'Working']);

        
        BranchLocations::create(['branch_id' => 1, 'location_id' => 1]);
        BranchLocations::create(['branch_id' => 2, 'location_id' => 4]);
    }
}
