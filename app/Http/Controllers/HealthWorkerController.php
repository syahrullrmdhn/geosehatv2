<?php

namespace App\Http\Controllers;

use App\Models\HealthWorker;
use App\Models\Region;
use Illuminate\Http\Request;

class HealthWorkerController extends Controller
{
    public function index()
    {
        // eager‑load relasi region
        $workers = HealthWorker::with('region')->latest()->paginate(10);
        return view('health_workers.index', compact('workers'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('health_workers.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'profession' => 'required|string|max:50',
            'region_id'  => 'required|exists:regions,id',
            'phone'      => 'nullable|string|max:20',
        ]);

        HealthWorker::create($data);

        return redirect()
            ->route('health_workers.index')
            ->with('success', 'Tenaga Kesehatan berhasil ditambah.');
    }

    public function edit(HealthWorker $health_worker)
    {
        $regions = Region::all();
        return view('health_workers.edit', compact('health_worker', 'regions'));
    }

    public function update(Request $request, HealthWorker $health_worker)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'profession' => 'required|string|max:50',
            'region_id'  => 'required|exists:regions,id',
            'phone'      => 'nullable|string|max:20',
        ]);

        $health_worker->update($data);

        return redirect()
            ->route('health_workers.index')
            ->with('success', 'Data Tenaga Kesehatan berhasil diperbarui.');
    }

    public function destroy(HealthWorker $health_worker)
    {
        $health_worker->delete();

        return redirect()
            ->route('health_workers.index')
            ->with('success', 'Tenaga Kesehatan berhasil dihapus.');
    }
}
