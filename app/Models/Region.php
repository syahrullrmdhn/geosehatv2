<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends LoggableModel
{
    protected $fillable = ['name', 'description'];
    protected static $logName = 'wilayah';
}
