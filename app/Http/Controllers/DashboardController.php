<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $stats = [
        [
            'icon' => 'o-exclamation-triangle',
            'color' => 'text-red-500',
            'value' => 1234,
            'label' => 'Total Kasus Aktif',
            'change' => '+12%',
            'delta_color' => 'text-green-600'
        ],
        [
            'icon' => 'o-user-group',
            'color' => 'text-blue-500',
            'value' => 456,
            'label' => 'Total Tenaga Kesehatan',
            'change' => '+5%',
            'delta_color' => 'text-green-600'
        ],
        [
            'icon' => 'o-clock',
            'color' => 'text-yellow-500',
            'value' => 78,
            'label' => 'Kasus Hari Ini',
            'change' => '-3%',
            'delta_color' => 'text-red-600'
        ],
        [
            'icon' => 'o-check-circle',
            'color' => 'text-green-500',
            'value' => '89%',
            'label' => 'Tingkat Penanganan',
            'change' => '+2%',
            'delta_color' => 'text-green-600'
        ],
    ];

    $zones = [
        ['label' => 'Zona Merah (> 100 kasus)', 'color' => 'bg-red-500'],
        ['label' => 'Zona Kuning (50-100 kasus)', 'color' => 'bg-yellow-400'],
        ['label' => 'Zona Hijau (≤ 50 kasus)', 'color' => 'bg-green-500'],
    ];

    $performance = [
        'Ditangani' => 60,
        'Proses'    => 30,
        'Menunggu'  => 10,
    ];

    $latestCases = [
        [
            'id' => 'KS-2024-001',
            'region' => 'Jakarta Selatan',
            'hw' => 'dr. Ahmad Yani',
            'status' => 'ditangani',
            'color' => 'green',
            'date' => '24 Jan 2024'
        ],
        [
            'id' => 'KS-2024-002',
            'region' => 'Bandung',
            'hw' => 'dr. Ratna Sari',
            'status' => 'proses',
            'color' => 'yellow',
            'date' => '24 Jan 2024'
        ],
        [
            'id' => 'KS-2024-003',
            'region' => 'Surabaya',
            'hw' => 'dr. Budi Santoso',
            'status' => 'menunggu',
            'color' => 'red',
            'date' => '23 Jan 2024'
        ],
        [
            'id' => 'KS-2024-004',
            'region' => 'Medan',
            'hw' => 'dr. Lisa Permata',
            'status' => 'ditangani',
            'color' => 'green',
            'date' => '23 Jan 2024'
        ],
    ];

    return view('dashboard.index', compact('stats', 'zones', 'performance', 'latestCases'));
}

}
