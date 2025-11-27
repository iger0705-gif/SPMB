<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role Check Methods
    public function isPendaftar()
    {
        return $this->role === 'pendaftar';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVerifikator()
    {
        return $this->role === 'verifikator_adm';
    }

    public function isKeuangan()
    {
        return $this->role === 'keuangan';
    }

    public function isKepsek()
    {
        return $this->role === 'kepsek';
    }
}