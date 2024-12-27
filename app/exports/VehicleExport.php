<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data kendaraan dari database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vehicle::all()->map(function ($vehicle) {
            return [
                'ID' => $vehicle->id,
                'Type' => $vehicle->vehicle_type,
                'License Plate' => $vehicle->license_plate,
                'Brand' => $vehicle->brand,
                'Model' => $vehicle->model,
                'Last Service Date' => $vehicle->last_service_date,
                'Next Service Date' => $vehicle->next_service_date,
            ];
        });
    }

    /**
     * Definisikan header kolom di Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Type',
            'License Plate',
            'Brand',
            'Model',
            'Last Service Date',
            'Next Service Date',
        ];
    }
}
