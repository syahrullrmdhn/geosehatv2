<?php

namespace App\Http\Controllers;

use App\Models\CaseRecord;
use App\Models\HealthWorker;
use App\Models\Disease;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalCases    = CaseRecord::sum('count');
        $totalHW       = HealthWorker::count();
        $todayCases    = CaseRecord::whereDate('date_reported', now()->toDateString())->sum('count');
        $totalDiseases = Disease::count();

        $stats = [
            [
                'icon'  => 'o-exclamation-triangle',
                'color' => 'red',
                'value' => $totalCases,
                'label' => 'Total Kasus',
            ],
            [
                'icon'  => 'o-user-group',
                'color' => 'blue',
                'value' => $totalHW,
                'label' => 'Tenaga Kesehatan',
            ],
            [
                'icon'  => 'o-clock',
                'color' => 'yellow',
                'value' => $todayCases,
                'label' => 'Kasus Hari Ini',
            ],
            [
                'icon'  => 'o-book-open',
                'color' => 'green',
                'value' => $totalDiseases,
                'label' => 'Total Penyakit',
            ],
        ];

        // Data peta
        $mapData = CaseRecord::with('region')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(fn($c) => [
                'lat'    => $c->latitude,
                'lng'    => $c->longitude,
                'count'  => $c->count,
                'region' => $c->region->name,
            ]);

        // Distribusi penyakit
        $diseaseDistribution = Disease::leftJoin('case_records', 'diseases.id', '=', 'case_records.disease_id')
            ->select('diseases.name', DB::raw('COALESCE(SUM(case_records.count),0) as count'))
            ->groupBy('diseases.id', 'diseases.name')
            ->get()
            ->map(function ($row, $idx) {
                $colors = ['bg-green-500','bg-yellow-400','bg-red-500','bg-blue-500','bg-pink-500'];
                $row['color'] = $colors[$idx % count($colors)];
                return $row;
            });

        // Distribusi per wilayah
        $regionDistribution = Region::leftJoin('case_records', 'regions.id', '=', 'case_records.region_id')
            ->select('regions.name', DB::raw('COALESCE(SUM(case_records.count),0) as count'))
            ->groupBy('regions.id', 'regions.name')
            ->orderByDesc('count')
            ->get();

        // 10 kasus terbaru
        $latestCases = CaseRecord::with(['region','disease'])
            ->latest('date_reported')
            ->limit(10)
            ->get()
            ->map(fn($c) => [
                'id'      => $c->id,
                'region'  => $c->region->name,
                'disease' => $c->disease->name,
                'count'   => $c->count,
                'date'    => $c->date_reported->format('d M Y'),
            ]);

        return view('dashboard.index', compact(
            'stats','mapData','latestCases','diseaseDistribution','regionDistribution'
        ));
    }
}
