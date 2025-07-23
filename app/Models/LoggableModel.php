<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LoggableModel extends Model
{
    use LogsActivity;

    // Konfigurasi logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName(class_basename($this))
            ->logOnlyDirty();
    }

    // (Optional, untuk deskripsi custom event)
    public function getDescriptionForEvent(string $eventName): string
    {
        return class_basename($this) . " {$eventName}";
    }
}
