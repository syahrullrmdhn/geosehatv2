@extends('layouts.app')
@section('title','Heatmap')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Heatmap Kasus</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <div id="chart-heatmap" style="min-height:320px; height:380px;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dummy data: 6 zona x 7 hari
    const zones = ['Zona A', 'Zona B', 'Zona C', 'Zona D', 'Zona E', 'Zona F'];
    const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    function randomArray() {
        return days.map(() => Math.floor(Math.random() * 60));
    }
    const series = zones.map(z => ({
        name: z,
        data: randomArray()
    }));

    var options = {
        chart: {
            height: 360,
            type: 'heatmap',
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        dataLabels: { enabled: false },
        plotOptions: {
            heatmap: {
                shadeIntensity: 0.6,
                radius: 8,
                useFillColorAsStroke: false,
                colorScale: {
                    ranges: [
                        { from: 0, to: 20, color: '#10b981', name: 'Rendah' },   // hijau
                        { from: 21, to: 40, color: '#f59e0b', name: 'Sedang' },  // kuning
                        { from: 41, to: 60, color: '#ef4444', name: 'Tinggi' }   // merah
                    ]
                }
            }
        },
        stroke: { width: 1, colors: ['#fff'] },
        series: series,
        xaxis: {
            categories: days,
            axisTicks: { show: false },
            axisBorder: { show: false },
            labels: {
                style: { colors: '#6b7280', fontSize: '13px' }
            }
        },
        yaxis: {
            labels: {
                style: { colors: '#6b7280', fontSize: '13px' }
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            labels: { colors: '#6b7280' }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return `Jumlah kasus: ${val}`;
                }
            }
        },
        grid: {
            show: true,
            borderColor: '#e5e7eb',
            padding: { left: 0, right: 0, top: 0, bottom: 0 }
        },
        responsive: [{
            breakpoint: 700,
            options: { chart: { height: 300 } }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart-heatmap"), options);
    chart.render();
});
</script>
@endpush
