<?php

namespace App\Http\Controllers;

use App\Models\AlertThreshold;
use App\Models\Region;
use App\Models\Disease;
use Illuminate\Http\Request;

class AlertThresholdController extends Controller
{
    public function index()
    {
        $thresholds = AlertThreshold::with(['region', 'disease'])->get();
        return view('alerts.threshold.index', compact('thresholds'));
    }

    public function create()
    {
        $regions = Region::all();
        $diseases = Disease::all();
        return view('alerts.threshold.create', compact('regions', 'diseases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id'  => 'required|exists:regions,id',
            'disease_id' => 'required|exists:diseases,id',
            'threshold'  => 'required|integer|min:1'
        ]);

        AlertThreshold::create($request->only(['region_id', 'disease_id', 'threshold']));
        return redirect()->route('alerts.threshold.index')->with('success', 'Threshold berhasil ditambahkan.');
    }

    public function edit(AlertThreshold $threshold)
    {
        $regions = Region::all();
        $diseases = Disease::all();
        return view('alerts.threshold.edit', compact('threshold', 'regions', 'diseases'));
    }

    public function update(Request $request, AlertThreshold $threshold)
    {
        $request->validate([
            'region_id'  => 'required|exists:regions,id',
            'disease_id' => 'required|exists:diseases,id',
            'threshold'  => 'required|integer|min:1'
        ]);

        $threshold->update($request->only(['region_id', 'disease_id', 'threshold']));
        return redirect()->route('alerts.threshold.index')->with('success', 'Threshold berhasil diperbarui.');
    }

    public function destroy(AlertThreshold $threshold)
    {
        $threshold->delete();
        return redirect()->route('alerts.threshold.index')->with('success', 'Threshold berhasil dihapus.');
    }
}
