<?php
namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::all();
        return view('diseases.index', compact('diseases'));
    }

    public function create()
    {
        // Tampilkan form create
        return view('diseases.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Simpan ke database
        Disease::create($data);

        // Redirect kembali ke list dengan pesan sukses
        return redirect()
            ->route('diseases.index')
            ->with('success', 'Penyakit berhasil ditambahkan.');
    }
}
