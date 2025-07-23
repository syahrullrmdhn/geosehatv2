@extends('layouts.app')
@section('title', 'Prediksi Kasus')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Prediksi Kasus</h2>
          <p class="text-sm text-gray-500 mt-1">
            Proyeksi jumlah kasus 6 bulan ke depan berdasarkan data historis
          </p>
        </div>
        <div class="mt-3 sm:mt-0 bg-purple-50 text-purple-800 px-3 py-1 rounded-full text-xs">
          <span class="font-medium">Algoritma:</span> Rata-rata Δ bulanan
        </div>
      </div>
      <div class="mt-4">
        <div id="chart-predictive" style="height:300px"></div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const labels = @json($labels);
  const histData = @json($dataHistoric);
  const fcData = @json($dataForecast);

  new ApexCharts(document.querySelector("#chart-predictive"), {
    chart: {
      type: 'area',
      height: 300,
      toolbar: { show: false },
      fontFamily: 'inherit',
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800
      }
    },
    series: [
      {
        name: 'Historis',
        data: histData
      },
      {
        name: 'Prediksi',
        data: fcData
      }
    ],
    xaxis: {
      categories: labels,
      labels: { style: { colors: '#6b7280' } },
      axisBorder: { show: false }
    },
    stroke: {
      curve: 'smooth',
      width: 2,
      dashArray: [0, 4]
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.6,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 95, 100]
      }
    },
    colors: ['#64748b', '#7c3aed'],
    legend: {
      position: 'top',
      horizontalAlign: 'left',
      markers: {
        radius: 4
      }
    },
    grid: {
      borderColor: '#e5e7eb',
      strokeDashArray: 4,
      padding: {
        top: 20
      }
    },
    tooltip: {
      shared: true,
      intersect: false,
      style: {
        fontFamily: 'inherit'
      },
      y: {
        formatter: val => `${val} kasus`
      }
    },
    markers: {
      size: 4,
      strokeWidth: 0,
      hover: {
        size: 6
      }
    }
  }).render();
});
</script>
@endpush
