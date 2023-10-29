<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'temperature',
        'humidity',
        'dew_temperature',
        'fan_active'
    ];

    protected $hidden = ['user_id', 'id'];
}
