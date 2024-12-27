<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user',
        'reservation_date',
        'start_time',
        'end_time',
        'approved_status_level1',
        'approved_status_level2',
    ];


    /**
     * Relasi dengan model Vehicle
     */


     public function vehicleUsage()
    {
        return $this->hasOne(VehicleUsage::class, 'reservation_id'); 
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
     public function usages()
    {
        return $this->hasMany(VehicleUsage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function vehicleUsages()
    {
        return $this->hasMany(VehicleUsage::class);
    }
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'driver');
    }
    /**
     * Relasi dengan model User (Level 1 Approver)
     */
    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approved_by_level1');
    }

    /**
     * Relasi dengan model User (Level 2 Approver)
     */
    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approved_by_level2');
    }
}
