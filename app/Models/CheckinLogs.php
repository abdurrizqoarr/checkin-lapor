<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinLogs extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'checkin_logs';

    protected $fillable = [
        'user_id',
        'point_qr_id',
        'waktu_checkin',
        'foto_bukti',
        'latitude',
        'longitude',
        'ip'
    ];

    protected $casts = [
        'waktu_checkin' => 'datetime',
    ];

    public function pointQr()
    {
        return $this->belongsTo(PointQr::class, 'point_qr_id');
    }
}
