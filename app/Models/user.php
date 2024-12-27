<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship to Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); 
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relasi dengan tabel vehicle_usages (pengemudi kendaraan).
     */
    public function vehicleUsages()
    {
        return $this->hasMany(VehicleUsage::class, 'driver_id');
    }

    /**
     * Relasi dengan tabel reservations untuk persetujuan level 1.
     */
    public function approvalLevel1()
    {
        return $this->hasMany(Reservation::class, 'approved_by_level1');
    }

    /**
     * Relasi dengan tabel reservations untuk persetujuan level 2.
     */
    public function approvalLevel2()
    {
        return $this->hasMany(Reservation::class, 'approved_by_level2');
    }
}
