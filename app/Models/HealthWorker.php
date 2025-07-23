<?php
namespace App\Models;

class HealthWorker extends LoggableModel
{
    protected $fillable = [
        'name', 'profession', 'region_id', 'phone',
    ];
    protected static $logName = 'tenaga_kesehatan';

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
