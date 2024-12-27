<?php
// app/Models/VehicleUsage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUsage extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'driver', 'distance_travelled', 'fuel_used', 'usage_date','end_date'];

    /**
     * Relasi dengan tabel reservations (pemakaian terkait dengan pemesanan).
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function reservation()
    {
    return $this->belongsTo(Reservation::class, 'driver');
    }
    public function usages()
    {
        return $this->hasMany(VehicleUsage::class);
    }
}
