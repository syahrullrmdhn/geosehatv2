<?php
namespace App\Models;

class CaseRecord extends LoggableModel
{
    protected $table = 'case_records';

    protected $fillable = [
        'date_reported',
        'region_id',
        'disease_id',
        'count',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'date_reported' => 'date',
    ];

    protected static $logName = 'kasus';

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
