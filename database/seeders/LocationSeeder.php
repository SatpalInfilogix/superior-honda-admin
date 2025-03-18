<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create(['name' => 'Kingston']);
        Location::create(['name' => 'Negril']);
        Location::create(['name' => 'Montego Bay']);
        Location::create(['name' => 'Ocho Rios']);
    }
}
