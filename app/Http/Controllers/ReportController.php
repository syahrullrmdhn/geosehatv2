<?php
namespace App\Http\Controllers;

class ReportController extends Controller
{
    public function export()
    {
        return view('reports.export');
    }

    public function scheduled()
    {
        return view('reports.scheduled');
    }
}
