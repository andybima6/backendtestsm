<?php
// app/Exports/ReservationExport.php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservationExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    // Menambahkan konstruktor untuk menerima rentang tanggal
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Mengambil data dari database berdasarkan rentang tanggal
    public function collection()
    {
        return Reservation::with('vehicle')
            ->whereBetween('reservation_date', [$this->startDate, $this->endDate])
            ->get()
            ->map(function ($reservation) {
                return [
                    'ID' => $reservation->id,
                    'Vehicle' => $reservation->vehicle->license_plate . ' (' . $reservation->vehicle->brand . ' - ' . $reservation->vehicle->model . ')',
                    'User' => $reservation->user,
                    'Reservation Date' => $reservation->reservation_date,
                    'Start Time' => $reservation->start_time,
                    'End Time' => $reservation->end_time,
                    'Status Admin' => ucfirst($reservation->approved_status_level1),
                    'Status Approval' => ucfirst($reservation->approved_status_level2),
                ];
            });
    }

    // Menambahkan heading untuk kolom
    public function headings(): array
    {
        return [
            'ID',
            'Vehicle',
            'User',
            'Reservation Date',
            'Start Time',
            'End Time',
            'Status Admin',
            'Status Approval',
        ];
    }
}
