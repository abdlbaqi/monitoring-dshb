<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nip', 'jabatan', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

   public function isAdmin()
{
    return $this->role === 'admin'; // atau sesuaikan dengan struktur databasenya
}

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function monitoringLogs()
    {
        return $this->hasMany(MonitoringLog::class);
    }
}