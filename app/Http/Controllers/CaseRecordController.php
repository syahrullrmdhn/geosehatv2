<?php

namespace App\Http\Controllers;

use App\Models\CaseRecord;
use App\Models\Region;
use App\Models\Disease;
use Illuminate\Http\Request;

class CaseRecordController extends Controller
{
    /**
     * Tampilkan daftar kasus
     */
    public function index()
    {
        $records = CaseRecord::with(['region', 'disease'])
                     ->latest('date_reported')
                     ->paginate(10);

        return view('cases.index', compact('records'));
    }

    /**
     * Tampilkan form input kasus
     */
    public function create()
    {
        $regions  = Region::pluck('name', 'id');
        $diseases = Disease::pluck('name', 'id');

        return view('cases.create', compact('regions', 'diseases'));
    }

    /**
     * Simpan data kasus baru, termasuk latitude & longitude
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date_reported' => 'required|date',
            'region_id'     => 'required|exists:regions,id',
            'disease_id'    => 'required|exists:diseases,id',
            'count'         => 'required|integer|min:0',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
        ]);

        CaseRecord::create($data);

        return redirect()
            ->route('cases.index')
            ->with('success', 'Data kasus berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu kasus
     */
    public function show(CaseRecord $case)
    {
        $case->load(['region', 'disease']);
        return view('cases.show', compact('case'));
    }

    /**
     * Tampilkan form edit kasus
     */
    public function edit(CaseRecord $case)
    {
        $regions  = Region::pluck('name', 'id');
        $diseases = Disease::pluck('name', 'id');
        return view('cases.edit', compact('case', 'regions', 'diseases'));
    }

    /**
     * Update data kasus
     */
    public function update(Request $request, CaseRecord $case)
    {
        $data = $request->validate([
            'date_reported' => 'required|date',
            'region_id'     => 'required|exists:regions,id',
            'disease_id'    => 'required|exists:diseases,id',
            'count'         => 'required|integer|min:0',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
        ]);

        $case->update($data);

        return redirect()
            ->route('cases.index')
            ->with('success', 'Data kasus berhasil diperbarui.');
    }

    /**
     * Hapus data kasus
     */
    public function destroy(CaseRecord $case)
    {
        $case->delete();
        return redirect()
            ->route('cases.index')
            ->with('success', 'Data kasus berhasil dihapus.');
    }

    /**
     * Tampilkan peta sebaran kasus
     */
    public function map()
    {
        $cases = CaseRecord::with(['region','disease'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(fn($c) => [
                'lat'      => $c->latitude,
                'lng'      => $c->longitude,
                'count'    => $c->count,
                'region'   => $c->region->name,
                'disease'  => $c->disease->name,
            ]);

        return view('cases.map', ['cases' => $cases]);
    }
}
