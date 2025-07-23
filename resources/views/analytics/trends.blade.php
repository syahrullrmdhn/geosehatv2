@extends('layouts.app')
@section('title', 'Grafik Tren Kasus')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Grafik Tren Kasus</h2>
          <p class="text-sm text-gray-500 mt-1">
            Perkembangan jumlah kasus dalam 6 bulan terakhir
          </p>
        </div>
        <div class="mt-3 sm:mt-0 bg-blue-50 text-blue-800 px-3 py-1 rounded-full text-xs">
          <span class="font-medium">Algoritma:</span> Agregasi bulanan (SUM)
        </div>
      </div>
      <div class="mt-4">
        <canvas id="chart-trends" class="w-full" style="height:300px"></canvas>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('chart-trends').getContext('2d');
  const labels = @json($labels);
  const data = @json($data);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Jumlah Kasus',
        data,
        tension: 0.3,
        borderColor: '#2563eb',
        backgroundColor: 'rgba(37, 99, 235, 0.05)',
        borderWidth: 2,
        pointBackgroundColor: '#fff',
        pointBorderColor: '#2563eb',
        pointBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1f2937',
          titleColor: '#f9fafb',
          bodyColor: '#f9fafb',
          borderColor: '#374151',
          borderWidth: 1,
          padding: 12
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#6b7280' }
        },
        y: {
          grid: { color: '#f3f4f6' },
          beginAtZero: true,
          ticks: { color: '#6b7280' }
        }
      }
    }
  });
});
</script>
@endpush
