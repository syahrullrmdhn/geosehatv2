<?php

namespace App\Http\Controllers;

use App\Models\HealthWorker;
use Illuminate\Http\Request;

class HealthWorkerController extends Controller
{
    // List all health workers
    public function index()
    {
        $workers = HealthWorker::latest()->paginate(10);
        return view('health_workers.index', compact('workers'));
    }

    // Show create form
    public function create()
    {
        return view('health_workers.create');
    }

    // Store new worker
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'profession' => 'required|string|max:50',
            'region'     => 'required|string|max:50',
            'phone'      => 'nullable|string|max:20',
        ]);

        HealthWorker::create($request->all());
        return redirect()->route('health_workers.index')->with('success', 'Tenaga Kesehatan berhasil ditambah.');
    }

    // Show edit form
    public function edit(HealthWorker $health_worker)
    {
        return view('health_workers.edit', compact('health_worker'));
    }

    // Update
    public function update(Request $request, HealthWorker $health_worker)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'profession' => 'required|string|max:50',
            'region'     => 'required|string|max:50',
            'phone'      => 'nullable|string|max:20',
        ]);

        $health_worker->update($request->all());
        return redirect()->route('health_workers.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Delete
    public function destroy(HealthWorker $health_worker)
    {
        $health_worker->delete();
        return redirect()->route('health_workers.index')->with('success', 'Tenaga Kesehatan dihapus.');
    }
}
