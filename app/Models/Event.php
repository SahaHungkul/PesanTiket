<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'judul',
        'tanggal',
        'lokasi',
        'kuota',
        'deskripsi',
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
