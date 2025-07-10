@extends('layouts.app')
@section('title', 'Dashboard Pemantauan Kesehatan')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    :root {
        --primary: #3b82f6;
        --primary-light: #93c5fd;
        --primary-dark: #1d4ed8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray-light: #f3f4f6;
        --gray-medium: #e5e7eb;
        --gray-dark: #6b7280;
    }
    
    #mainMap {
        border-radius: 0.75rem;
        border: 1px solid var(--gray-medium);
        z-index: 0;
    }
    
    .health-card {
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    
    .health-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    .status-badge {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .table-row-hover:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen">
<div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Pemantauan Kesehatan</h1>
            <p class="text-gray-600">Ringkasan statistik dan pemantauan kasus terkini</p>
        </div>
        <div class="text-sm bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-xs">
            <span class="text-gray-500">Update terakhir:</span>
            <span class="font-medium">{{ now()->format('d M Y, H:i') }}</span>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($stats as $card)
            <div class="health-card bg-white rounded-xl p-5 shadow-sm border-l-{{ $card['color'] }}-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-{{ $card['color'] }}-50">
                        <x-heroicon-{{ $card['icon'] }} class="h-6 w-6 text-{{ $card['color'] }}-600" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</p>
                        <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
                    </div>
                </div>
                @if(isset($card['change']))
                    <div class="mt-3 flex items-center">
                        @if(str_contains($card['change'], '+'))
                            <x-heroicon-s-arrow-trending-up class="h-4 w-4 text-{{ $card['delta_color'] }}-500" />
                        @else
                            <x-heroicon-s-arrow-trending-down class="h-4 w-4 text-{{ $card['delta_color'] }}-500" />
                        @endif
                        <span class="ml-1 text-sm font-medium text-{{ $card['delta_color'] }}-600">{{ $card['change'] }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Data Visualization Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Map Section --}}
        <div class="lg:col-span-3 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div>
                        <h3 class="font-semibold text-gray-800">Peta Sebaran Kasus</h3>
                        <p class="text-sm text-gray-500">Lokasi kasus berdasarkan wilayah</p>
                    </div>
                    <select class="border-gray-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm text-sm py-2 pl-3 pr-8">
                        <option>Semua Zona</option>
                        @foreach($zones as $zone)
                            <option>{{ $zone['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="p-4 flex-1">
                    <div id="mainMap" class="w-full h-full min-h-[380px]"></div>
                </div>
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-600">
                        @foreach($zones as $zone)
                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full {{ $zone['color'] }}"></span>
                            <span>{{ $zone['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Performance Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">Performa Penanganan</h3>
                    <p class="text-sm text-gray-500">Status penyelesaian kasus terkini</p>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center p-6">
                    <div class="relative h-64 w-full">
                        <canvas id="performanceChart"></canvas>
                    </div>
                    <div id="chart-legend" class="mt-6 grid grid-cols-3 gap-4 w-full max-w-md"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Cases Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-gray-800">Kasus Terbaru</h3>
                <p class="text-sm text-gray-500">10 kasus terakhir yang dilaporkan</p>
            </div>
            <a href="{{ route('cases.index') }}" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                Lihat Semua
                <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Kasus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenaga Kesehatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($latestCases as $case)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $case['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $case['region'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $case['hw'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge px-2.5 py-1 inline-flex items-center rounded-full capitalize
                                @if($case['color']=='green') bg-green-100 text-green-800
                                @elseif($case['color']=='yellow') bg-yellow-100 text-yellow-800
                                @elseif($case['color']=='red') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($case['color']=='green')
                                    <x-heroicon-s-check-circle class="h-3 w-3 mr-1" />
                                @elseif($case['color']=='yellow')
                                    <x-heroicon-s-exclamation-triangle class="h-3 w-3 mr-1" />
                                @elseif($case['color']=='red')
                                    <x-heroicon-s-x-circle class="h-3 w-3 mr-1" />
                                @endif
                                {{ $case['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $case['date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-primary hover:text-primary-dark">
                                <x-heroicon-s-eye class="h-5 w-5" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Performance Chart
    const performanceCtx = document.getElementById('performanceChart');
    if (performanceCtx) {
        const performanceData = @json(array_values($performance));
        const performanceLabels = @json(array_keys($performance));
        const backgroundColors = [
            'rgba(16, 185, 129, 0.8)',   // Green
            'rgba(245, 158, 11, 0.8)',  // Yellow
            'rgba(239, 68, 68, 0.8)'     // Red
        ];
        const borderColors = [
            'rgba(16, 185, 129, 1)',
            'rgba(245, 158, 11, 1)',
            'rgba(239, 68, 68, 1)'
        ];

        const performanceChart = new Chart(performanceCtx, {
            type: 'doughnut',
            data: {
                labels: performanceLabels,
                datasets: [{
                    data: performanceData,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1,
                    spacing: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        boxPadding: 6,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Custom Legend
        const legendContainer = document.getElementById('chart-legend');
        performanceLabels.forEach((label, index) => {
            const val = performanceData[index];
            const total = performanceData.reduce((a, b) => a + b, 0);
            const percentage = Math.round((val / total) * 100);
            
            const legendItem = document.createElement('div');
            legendItem.className = 'flex flex-col items-center p-2 rounded-lg bg-gray-50';
            legendItem.innerHTML = `
                <div class="flex items-center gap-2 mb-1">
                    <span class="h-3 w-3 rounded-full" style="background-color: ${backgroundColors[index]}; border: 1px solid ${borderColors[index]};"></span>
                    <span class="text-sm font-medium text-gray-700">${label}</span>
                </div>
                <span class="text-xl font-bold text-gray-900">${val}</span>
                <span class="text-xs text-gray-500 mt-1">${percentage}% dari total</span>
            `;
            legendContainer.appendChild(legendItem);
        });
    }

    // Leaflet Map
    const mapElement = document.getElementById('mainMap');
    if (mapElement) {
        const map = L.map('mainMap').setView([-2.5489, 118.0149], 5);
        
        // Light map theme suitable for health data
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Custom health markers
        const healthIcon = (color) => L.divIcon({
            className: 'health-marker',
            html: `
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="${color}" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                </svg>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        // Sample health data points
        const healthFacilities = [
            { name: 'RSUD Jakarta', coords: [-6.2088, 106.8456], cases: 120, status: 'high', color: '#ef4444' },
            { name: 'RS Bandung', coords: [-6.9175, 107.6191], cases: 75, status: 'medium', color: '#f59e0b' },
            { name: 'RS Surabaya', coords: [-7.2575, 112.7521], cases: 90, status: 'medium', color: '#f59e0b' },
            { name: 'RS Medan', coords: [3.5952, 98.6722], cases: 45, status: 'low', color: '#10b981' }
        ];

        // Add markers with custom icons
        healthFacilities.forEach(facility => {
            const marker = L.marker(facility.coords, {
                icon: healthIcon(facility.color)
            }).addTo(map);
            
            marker.bindPopup(`
                <div class="font-sans">
                    <h4 class="font-bold text-lg mb-1">${facility.name}</h4>
                    <div class="flex items-center mb-1">
                        <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: ${facility.color}"></span>
                        <span class="text-sm">Status: ${facility.status}</span>
                    </div>
                    <p class="text-sm">Total Kasus: <span class="font-semibold">${facility.cases}</span></p>
                </div>
            `);
        });

        // Add a simple legend
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = () => {
            const div = L.DomUtil.create('div', 'bg-white p-3 rounded-lg shadow-sm border border-gray-200 text-sm');
            div.innerHTML = `
                <h4 class="font-semibold mb-2">Keterangan Status</h4>
                <div class="flex items-center mb-1">
                    <span class="inline-block w-3 h-3 rounded-full mr-2 bg-red-500"></span>
                    <span>Tinggi</span>
                </div>
                <div class="flex items-center mb-1">
                    <span class="inline-block w-3 h-3 rounded-full mr-2 bg-yellow-500"></span>
                    <span>Sedang</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full mr-2 bg-green-500"></span>
                    <span>Rendah</span>
                </div>
            `;
            return div;
        };
        legend.addTo(map);
    }
});
</script>
@endpush