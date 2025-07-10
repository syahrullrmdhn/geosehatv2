@extends('layouts.app')
@section('title','Prediksi Kasus')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Prediksi Kasus</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <div id="chart-predictive" style="min-height:320px; height:380px;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Contoh data dummy prediksi
    const labels = ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'];
    const dataHistoris = [31, 34, 36, 29, 28, 32, 33];
    const dataPrediksi  = [33, 35, 36, 39, 41, 44, 47];

    var options = {
        chart: {
            type: 'area',
            height: 340,
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        series: [
            {
                name: 'Historis',
                data: dataHistoris
            },
            {
                name: 'Prediksi',
                data: dataPrediksi
            }
        ],
        xaxis: {
            categories: labels,
            labels: { style: { colors: '#6b7280', fontSize: '13px' } },
            axisTicks: { show: false },
            axisBorder: { show: false }
        },
        yaxis: {
            min: 0,
            labels: { style: { colors: '#6b7280', fontSize: '13px' } }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 0.2,
                opacityFrom: 0.35,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        colors: ['#64748b', '#2563eb'],
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: '#6b7280' }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return `Jumlah kasus: ${val}`;
                }
            }
        },
        responsive: [{
            breakpoint: 700,
            options: { chart: { height: 260 } }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart-predictive"), options);
    chart.render();
});
</script>
@endpush
