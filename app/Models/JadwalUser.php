<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUser extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_users';

    protected $fillable = [
        'user_id',
        'hari',
    ];

    /**
     * Relasi ke model User
     */
    public function jadwal()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Pilihan enum hari
     */
    public static function hariEnum(): array
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];
    }
}
