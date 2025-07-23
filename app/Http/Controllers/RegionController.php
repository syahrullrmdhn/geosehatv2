<?php
namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        return view('regions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Region::create($data);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $region->update($data);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil diubah.');
    }

    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }
}
