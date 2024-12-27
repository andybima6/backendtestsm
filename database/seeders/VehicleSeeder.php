<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::create([
            'vehicle_type' => 'passenger',
            'license_plate' => 'AB 1234 CD',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'last_service_date' => '2023-06-15',
            'next_service_date' => '2023-12-15',
        ]);

        Vehicle::create([
            'vehicle_type' => 'cargo',
            'license_plate' => 'BC 5678 EF',
            'brand' => 'Isuzu',
            'model' => 'Elf',
            'last_service_date' => '2023-05-10',
            'next_service_date' => '2023-11-10',
        ]);

        Vehicle::create([
            'vehicle_type' => 'passenger',
            'license_plate' => 'CD 9012 GH',
            'brand' => 'Honda',
            'model' => 'Civic',
            'last_service_date' => '2023-07-01',
            'next_service_date' => '2023-12-01',
        ]);
        
    }
}
