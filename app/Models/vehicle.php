<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_type', 'license_plate', 'brand', 'model',  'fuel_consumption', 'last_service_date', 'next_service_date'];

    /**
     * Relasi dengan tabel reservations (kendaraan yang dipilih untuk pemesanan).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relasi dengan tabel vehicle_usages (riwayat penggunaan kendaraan).
     */
    public function vehicleUsages()
    {
        return $this->hasMany(VehicleUsage::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

   
}
