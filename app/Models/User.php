<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const UPDATED_AT = null;

    protected $fillable = [
        'nama_lengkap',
        'foto',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Agar kode aplikasi yang menggunakan "name"
    // tetap bisa membaca nama_lengkap di database.
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    // Agar kode aplikasi yang menggunakan photo_path
    // tetap bisa membaca kolom foto di database.
    public function getPhotoPathAttribute()
    {
        return $this->foto;
    }

    public function setPhotoPathAttribute($value)
    {
        $this->attributes['foto'] = $value;
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}