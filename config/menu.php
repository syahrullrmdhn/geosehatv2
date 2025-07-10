<?php
// config/menu.php

return [
    // Core
    [
        'title' => 'Dashboard',
        'icon'  => 'home',
        'route' => 'dashboard',
    ],
    [
        'title' => 'Data Kasus',
        'icon'  => 'table-cells',
        'route' => 'cases.index',
    ],
    [
        'title' => 'Input Data Kasus',
        'icon'  => 'plus-circle',
        'route' => 'cases.create',
    ],
    [
        'title' => 'Peta Kasus',
        'icon'  => 'map',
        'route' => 'cases.map',
    ],

    // Notifikasi & Alert
    [
        'header' => 'Notifikasi & Alert',
        'items'  => [
            [
                'title' => 'Threshold Alerts',
                'icon'  => 'bell-alert',
                'route' => 'alerts.threshold',
            ],
            [
                'title' => 'In-App Notifications',
                'icon'  => 'bell',
                'route' => 'notifications.index',
            ],
        ],
    ],

    // Laporan & Ekspor
    [
        'header' => 'Laporan & Ekspor',
        'items'  => [
            [
                'title' => 'Export Data',
                'icon'  => 'document-arrow-down',
                'route' => 'reports.export',
            ],
            [
                'title' => 'Scheduled Reports',
                'icon'  => 'calendar',
                'route' => 'reports.scheduled',
            ],
        ],
    ],

    // Analitik & Visualisasi
    [
        'header' => 'Analitik & Visualisasi',
        'items'  => [
            [
                'title' => 'Grafik Tren',
                'icon'  => 'chart-line',
                'route' => 'analytics.trends',
            ],
            [
                'title' => 'Heatmap',
                'icon'  => 'map',
                'route' => 'analytics.heatmap',
            ],
            [
                'title' => 'Prediksi Kasus',
                'icon'  => 'chart-pie',
                'route' => 'analytics.predictive',
            ],
        ],
    ],

    // Master Data
    [
        'header' => 'Master Data',
        'items'  => [
            [
                'title' => 'Penyakit',
                'icon'  => 'beaker',
                'route' => 'diseases.index',
            ],
            [
                'title' => 'Wilayah',
                'icon'  => 'location-marker',
                'route' => 'regions.index',
            ],
        ],
    ],

    // Manajemen Pengguna & Akses
    [
        'header' => 'Manajemen Pengguna',
        'items'  => [
            [
                'title' => 'Role & Permission',
                'icon'  => 'users',
                'route' => 'roles.index',
            ],
            [
                'title' => 'Two-Factor Auth',
                'icon'  => 'shield-check',
                'route' => 'security.2fa',
            ],
        ],
    ],

    // Integrasi & API
    [
        'header' => 'Integrasi & API',
        'items'  => [
            [
                'title' => 'API Docs',
                'icon'  => 'code-bracket-square',
                'route' => 'api.docs',
            ],
            [
                'title' => 'Webhooks',
                'icon'  => 'link',
                'route' => 'webhooks.index',
            ],
        ],
    ],

    // Mobile & Offline
    [
        'header' => 'Mobile & Offline',
        'items'  => [
            [
                'title' => 'PWA Settings',
                'icon'  => 'device-phone-mobile',
                'route' => 'pwa.settings',
            ],
            [
                'title' => 'Offline Sync',
                'icon'  => 'wifi-off',
                'route' => 'pwa.offline',
            ],
        ],
    ],

    // Keamanan & Compliance
    [
        'header' => 'Keamanan & Compliance',
        'items'  => [
            [
                'title' => 'Activity Log',
                'icon'  => 'clipboard-list',
                'route' => 'audit.index',
            ],
            [
                'title' => 'Backup & Restore',
                'icon'  => 'cloud-arrow-up',
                'route' => 'backup.index',
            ],
            [
                'title' => 'Data Privacy',
                'icon'  => 'shield-check',
                'route' => 'privacy.index',
            ],
        ],
    ],

    // Logout
    [
        'title'  => 'Logout',
        'icon'   => 'logout',
        'route'  => 'logout',
        'method' => 'post',
    ],
];
