<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'case_records';
    protected $fillable = [
        'patient_name',
        'disease_id',
        'region_id',
        'date_reported',
        'latitude',
        'longitude',
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
