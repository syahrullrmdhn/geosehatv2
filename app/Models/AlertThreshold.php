<?php
namespace App\Models;

class AlertThreshold extends LoggableModel
{
    protected $fillable = ['region_id', 'disease_id', 'threshold'];
    protected static $logName = 'threshold';

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
