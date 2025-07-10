<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthWorker extends Model
{
    protected $fillable = [
        'name', 'profession', 'region', 'phone'
    ];
}
