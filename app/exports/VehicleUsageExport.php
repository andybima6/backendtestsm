<?php

// app/Exports/VehicleUsageExport.php

namespace App\Exports;

use App\Models\VehicleUsage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleUsageExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Return all vehicle usages, or customize as needed
        return VehicleUsage::with('vehicle', 'reservation.user')->get([
            'id',
            'vehicle_id',
            'driver',
            'distance_travelled',
            'fuel_used',
            'usage_date',
            'end_date'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vehicle ID',
            'Driver',
            'Distance Travelled',
            'Fuel Used',
            'Usage Date',
            'End Date',
        ];
    }
}
