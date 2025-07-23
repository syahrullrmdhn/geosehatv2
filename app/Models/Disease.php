<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends LoggableModel
{
    protected $fillable = ['name', 'description'];
    protected static $logName = 'penyakit';
}
