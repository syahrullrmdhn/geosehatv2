<?php
namespace App\Http\Controllers;

use App\Models\CaseRecord;
use App\Models\Disease;
use App\Models\Region;
use Illuminate\Http\Request;

class CaseRecordController extends Controller
{
    public function index()
    {
        $records = CaseRecord::with('disease','region')->paginate(10);
        return view('cases.index', compact('records'));
    }

    public function create()
    {
        $diseases = Disease::pluck('name','id');
        $regions  = Region::pluck('name','id');
        return view('cases.create', compact('diseases','regions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'disease_id'   => 'required|exists:diseases,id',
            'region_id'    => 'required|exists:regions,id',
            'date_reported'=> 'required|date',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
        ]);

        CaseRecord::create($data);

        return redirect()
            ->route('cases.index')
            ->with('success','Kasus berhasil ditambahkan.');
    }

    public function map()
    {
        $cases = CaseRecord::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['patient_name','latitude','longitude']);

        return view('cases.map', compact('cases'));
    }
}
