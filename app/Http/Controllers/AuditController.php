<?php
namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    public function index()
{
    $logs = Activity::latest()->limit(10)->get();

    return view('audit.index', compact('logs'));
}
}
