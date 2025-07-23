<?php

namespace App\Http\Controllers;

use App\Models\CaseRecord;
use App\Models\Region;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /** Grafik Tren: 6 bulan terakhir */
    public function trends()
    {
        $start = now()->subMonths(5)->startOfMonth();
        $rows = CaseRecord::selectRaw('YEAR(date_reported) AS year, MONTH(date_reported) AS month, SUM(count) AS total')
            ->where('date_reported', '>=', $start)
            ->groupBy('year','month')
            ->orderBy('year')->orderBy('month')
            ->get();

        $labels = $rows->map(fn($r)=> Carbon::create($r->year,$r->month,1)->format('M'))->toArray();
        $data   = $rows->pluck('total')->toArray();

        return view('analytics.trends', compact('labels','data'));
    }

    /** Grafik Prediktif: historis + forecast 6 bulan ke depan */
    public function predictive()
    {
        $months = 6;
        $start = now()->subMonths($months-1)->startOfMonth();
        $rows = CaseRecord::selectRaw('YEAR(date_reported) AS year, MONTH(date_reported) AS month, SUM(count) AS total')
            ->where('date_reported','>=',$start)
            ->groupBy('year','month')
            ->orderBy('year')->orderBy('month')
            ->get();

        // Historical labels & data
        $histLabels = $rows->map(fn($r)=> Carbon::create($r->year,$r->month,1)->format('M'))->toArray();
        $histData   = $rows->pluck('total')->toArray();

        // Rata‑rata perubahan bulanan
        $deltas = [];
        for($i=1; $i<count($histData); $i++){
            $deltas[] = $histData[$i] - $histData[$i-1];
        }
        $avgDelta = $deltas ? array_sum($deltas)/count($deltas) : 0;

        // Forecast 6 bulan ke depan
        $lastRow   = $rows->last();
        $lastDate  = Carbon::create($lastRow->year, $lastRow->month,1);
        $lastValue = end($histData);
        $fcLabels  = [];
        $fcData    = [];

        for($i=1; $i<=$months; $i++){
            $dt = $lastDate->copy()->addMonths($i);
            $fcLabels[] = $dt->format('M');
            $lastValue = max(0, round($lastValue + $avgDelta));
            $fcData[] = $lastValue;
        }

        $labels       = array_merge($histLabels, $fcLabels);
        $dataHistoric = $histData;
        $dataForecast = $fcData;

        return view('analytics.predictive', compact(
            'labels','dataHistoric','dataForecast'
        ));
    }

    /** Heatmap: distribusi kasus per hari dalam seminggu, per region */
    public function heatmap()
    {
        // Ambil seluruh region
        $regions = Region::all();
        $regionNames = $regions->pluck('name')->toArray();

        // Hari (Senin–Minggu)
        $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];

        // Data 7 hari terakhir
        $start = now()->subDays(6)->startOfDay();
        $cases = CaseRecord::selectRaw(
                'region_id, WEEKDAY(date_reported) AS wd, SUM(count) AS total'
            )
            ->where('date_reported','>=',$start)
            ->groupBy('region_id','wd')
            ->get();

        // Inisialisasi series
        $series = [];
        foreach($regions as $idx => $r){
            $series[$idx] = [
                'name' => $r->name,
                'data' => array_fill(0,7,0)
            ];
        }

        // Populate berdasarkan WEEKDAY: 0=Mon…6=Sun
        foreach($cases as $c){
            $idx = $regions->search(fn($r)=> $r->id === $c->region_id);
            if($idx !== false){
                $series[$idx]['data'][$c->wd] = $c->total;
            }
        }

        return view('analytics.heatmap', compact(
            'regionNames','days','series'
        ));
    }
}
