<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlertController,
    ApiController,
    AnalyticsController,
    AuditController,
    BackupController,
    CaseRecordController,
    DashboardController,
    DiseaseController,
    HealthWorkerController,
    NotificationController,
    PwaController,
    PrivacyController,
    ProfileController,
    RegionController,
    ReportController,
    RoleController,
    SecurityController,
    UserController,
    WebhookController,
    AuthController,
};

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {
    // Authentication
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    // Profile
    Route::get   ('profile',  [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch ('profile',  [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('profile',  [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cases
    Route::resource('cases', CaseRecordController::class)
         ->only(['index', 'create', 'store']);
    Route::get('cases/map', [CaseRecordController::class, 'map'])
         ->name('cases.map');

    // Alerts
    Route::get('alerts/threshold', [AlertController::class, 'threshold'])
         ->name('alerts.threshold');

    // Notifications
    Route::get ('notifications',           [NotificationController::class, 'index'])   ->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Reports & Exports
    Route::get('reports/export',    [ReportController::class, 'export'])   ->name('reports.export');
    Route::get('reports/scheduled', [ReportController::class, 'scheduled'])->name('reports.scheduled');

    // Analytics
    Route::get('analytics/trends',     [AnalyticsController::class, 'trends'])    ->name('analytics.trends');
    Route::get('analytics/heatmap',    [AnalyticsController::class, 'heatmap'])   ->name('analytics.heatmap');
    Route::get('analytics/predictive', [AnalyticsController::class, 'predictive'])->name('analytics.predictive');

    // Master Data
    Route::get('diseases', [DiseaseController::class, 'index'])->name('diseases.index');
    Route::get('regions',  [RegionController::class, 'index'])->name('regions.index');

    // ==== PENTING: Pakai resource dengan UNDERSCORE, BUKAN DASH ====
    Route::resource('health_workers', HealthWorkerController::class);

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Roles & Security
    Route::get('roles',       [RoleController::class, 'index'])     ->name('roles.index');
    Route::get('security/2fa',[SecurityController::class,'twoFactor'])->name('security.2fa');

    // API & Webhooks
    Route::get('api/docs',  [ApiController::class, 'docs'])   ->name('api.docs');
    Route::get('webhooks',  [WebhookController::class, 'index'])->name('webhooks.index');

    // PWA & Offline
    Route::get('pwa/settings',[PwaController::class, 'settings'])->name('pwa.settings');
    Route::get('pwa/offline', [PwaController::class, 'offlineSync'])->name('pwa.offline');

    // System: Audit, Backup, Privacy
    Route::get('audit',   [AuditController::class, 'index'])->name('audit.index');
    Route::get('backup',  [BackupController::class,'index'])->name('backup.index');
    Route::get('privacy', [PrivacyController::class,'index'])->name('privacy.index');

    Route::resource('roles', \App\Http\Controllers\RoleController::class);

});

require __DIR__ . '/auth.php';
