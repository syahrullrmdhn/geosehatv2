<?php
namespace App\Http\Controllers;

class AnalyticsController extends Controller
{
    public function trends()
    {
        return view('analytics.trends');
    }

    public function heatmap()
    {
        return view('analytics.heatmap');
    }

    public function predictive()
    {
        return view('analytics.predictive');
    }
}
