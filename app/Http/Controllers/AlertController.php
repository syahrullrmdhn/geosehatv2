<?php
namespace App\Http\Controllers;

use App\Models\AlertThreshold;

class AlertController extends Controller
{
    public function threshold()
    {
        $thresholds = AlertThreshold::with('disease','region')->get();
        return view('alerts.threshold', compact('thresholds'));
    }
}
