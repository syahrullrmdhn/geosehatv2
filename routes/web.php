<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\{
    AlertController,
    AlertThresholdController,
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
    TwoFactorController,
    UserController,
    WebhookController,
    AuthController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

// Public test endpoint for Telegram debugging
Route::get('/test-telegram', function () {
    $token  = config('app.telegram_bot_token', 'YOUR_TELEGRAM_BOT_TOKEN'); // or use env()
    $chatId = 1102209151; // Ganti dengan chat ID-mu

    $response = Http::asForm()
        ->timeout(5)
        ->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => '🔔 Ini pesan tes dari Laravel!',
        ]);

    return response()->json([
        'status' => $response->status(),
        'body'   => $response->body(),
    ]);
})->name('test.telegram');

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    // Profile
    Route::get   ('profile',  [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch ('profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile',  [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cases (map sebelum resource agar /cases/map tidak tertimpa)
    Route::get('cases/map', [CaseRecordController::class, 'map'])->name('cases.map');
    Route::resource('cases', CaseRecordController::class);

    // Threshold Alerts Resource
    Route::resource('alerts/threshold', AlertThresholdController::class, [
        'as' => 'alerts' // prefix route name: alerts.threshold.*
    ]);

    // Notifications
    Route::get ('notifications',           [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Reports & Exports
    Route::get('reports/export',        [ReportController::class, 'export'])   ->name('reports.export');
    Route::get('reports/scheduled',     [ReportController::class, 'scheduled'])->name('reports.scheduled');
    Route::get('reports/download/{id}', [ReportController::class, 'download'])->name('reports.download');

    // Analytics
    Route::get('analytics/trends',     [AnalyticsController::class, 'trends'])    ->name('analytics.trends');
    Route::get('analytics/heatmap',    [AnalyticsController::class, 'heatmap'])   ->name('analytics.heatmap');
    Route::get('analytics/predictive', [AnalyticsController::class, 'predictive'])->name('analytics.predictive');

    // Master Data
    Route::resource('diseases', DiseaseController::class)->except(['show']);
    Route::resource('regions',  RegionController::class) ->except(['show']);

    // Health Workers
    Route::resource('health_workers', HealthWorkerController::class);

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Security: 2FA Settings
    Route::get ('security/2fa',        [SecurityController::class, 'twoFactor'])    ->name('security.2fa');
    Route::post('security/2fa/enable', [SecurityController::class, 'enable2fa'])   ->name('security.2fa.enable');
    Route::post('security/2fa/disable',[SecurityController::class, 'disable2fa'])  ->name('security.2fa.disable');
});

// Two‑Factor Verification (accessible without full auth)
Route::get ('2fa', [TwoFactorController::class, 'showVerifyForm'])
     ->name('2fa.verify');
Route::post('2fa', [TwoFactorController::class, 'verify'])
     ->name('2fa.verify.post');

// Breeze/Laravel auth routes
require __DIR__ . '/auth.php';
