<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertThreshold extends Model
{
    protected $fillable = [
        'disease_id',
        'region_id',
        'threshold',
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
