<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class PointQr extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'point_qr';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['nama_point'];
}
