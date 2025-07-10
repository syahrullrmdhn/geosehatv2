<?php
namespace App\Http\Controllers;

use App\Models\Disease;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::all();
        return view('diseases.index', compact('diseases'));
    }
}
