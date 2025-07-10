<?php
namespace App\Http\Controllers;

use App\Models\Region;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }
}
