@extends('layouts.app')
@section('title', 'Heatmap Kasus')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Heatmap Kasus</h2>
          <p class="text-sm text-gray-500 mt-1">
            Distribusi kasus per wilayah dalam 7 hari terakhir
          </p>
        </div>
        <div class="mt-3 sm:mt-0 bg-amber-50 text-amber-800 px-3 py-1 rounded-full text-xs">
          <span class="font-medium">Algoritma:</span> Grup per weekday & region
        </div>
      </div>
      <div class="mt-4">
        <div id="chart-heatmap" style="height:300px"></div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  new ApexCharts(document.querySelector("#chart-heatmap"), {
    chart: {
      type: 'heatmap',
      height: 300,
      fontFamily: 'inherit',
      toolbar: { show: false }
    },
    series: @json($series),
    plotOptions: {
      heatmap: {
        shadeIntensity: 0.6,
        radius: 4,
        useFillColorAsStroke: false,
        colorScale: {
          ranges: [
            { from: 0, to: 20, color: '#10b981', name: 'Rendah' },
            { from: 21, to: 40, color: '#f59e0b', name: 'Sedang' },
            { from: 41, to: 9999, color: '#ef4444', name: 'Tinggi' }
          ]
        }
      }
    },
    dataLabels: { enabled: false },
    xaxis: {
      categories: @json($days),
      labels: { style: { colors: '#6b7280' } }
    },
    yaxis: {
      labels: { style: { colors: '#6b7280' } }
    },
    legend: {
      position: 'bottom',
      markers: {
        radius: 4
      }
    },
    tooltip: {
      style: {
        fontFamily: 'inherit'
      },
      y: {
        formatter: val => `${val} kasus`
      }
    },
    grid: {
      borderColor: '#e5e7eb',
      strokeDashArray: 4
    }
  }).render();
});
</script>
@endpush
