@extends('layouts.app')
@section('title','Grafik Tren')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Grafik Tren Kasus</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <canvas id="chart-trends" class="w-full" style="min-height:320px; height:380px;"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('chart-trends').getContext('2d');
    const chartTrends = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Jumlah Kasus',
                data: [12, 19, 13, 15, 10, 8],
                fill: false,
                borderColor: '#2563eb', // biru soft
                backgroundColor: '#2563eb',
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: {
                    grid: { display: false },
                    title: { display: false }
                },
                y: {
                    grid: { color: '#f3f4f6' },
                    ticks: { beginAtZero: true },
                    title: { display: false }
                }
            }
        }
    });
});
</script>
@endpush
