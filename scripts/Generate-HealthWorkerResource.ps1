<#
.SYNOPSIS
  Scaffold HealthWorker resource:
  - Model + migration
  - Resource controller
  - Route::resource(...)
  - Blade view stubs (index, create, edit)
#>

# 0. Pastikan dijalankan dari root Laravel
if (-not (Test-Path .\artisan)) {
    Write-Error "Jalankan skrip ini dari folder root proyek Laravel (di mana artisan ada)."
    exit 1
}

# 1. Buat Model + Migration
$modelFile = ".\app\Models\HealthWorker.php"
if (-not (Test-Path $modelFile)) {
    Write-Host "✔ Membuat Model HealthWorker + Migration..."
    php artisan make:model HealthWorker -m
} else {
    Write-Host "ℹ Model HealthWorker sudah ada, skip."
}

# 2. Buat Controller Resource
$controllerFile = ".\app\Http\Controllers\HealthWorkerController.php"
if (-not (Test-Path $controllerFile)) {
    Write-Host "✔ Membuat Resource Controller HealthWorkerController..."
    # --resource + --model menghasilkan semua method CRUD dan type‐hint model
    php artisan make:controller HealthWorkerController --resource --model=HealthWorker
} else {
    Write-Host "ℹ Controller HealthWorkerController sudah ada, skip."
}

# 3. Tambahkan Route::resource jika belum ada
$routesFile = "routes\web.php"
$routeLine = "    Route::resource('health-workers', HealthWorkerController::class);"
if (-not (Select-String -Path $routesFile -Pattern "health-workers")) {
    Write-Host "✔ Menambahkan Route::resource untuk health-workers di web.php..."
    # masukkan tepat setelah group auth (atau di akhir file)
    Add-Content -Path $routesFile -Value "`n$routeLine"
} else {
    Write-Host "ℹ Route health-workers sudah terdaftar, skip."
}

# 4. Buat folder Views
$viewDir = "resources\views\health-workers"
if (-not (Test-Path $viewDir)) {
    Write-Host "✔ Membuat folder views/health-workers..."
    New-Item -ItemType Directory -Path $viewDir | Out-Null
} else {
    Write-Host "ℹ Folder views/health-workers sudah ada, skip."
}

# 5. Stub Blade views: index, create, edit
$stubs = @{
    'index.blade.php' = @'
{{-- resources/views/health-workers/index.blade.php --}}
@extends("layouts.app")

@section("title","Daftar Tenaga Kesehatan")

@section("content")
<div class="space-y-4">
  <h2 class="text-2xl font-semibold">Daftar Tenaga Kesehatan</h2>
  <a href="{{ route("health-workers.create") }}"
     class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
    Tambah Tenaga Kesehatan
  </a>
  <table class="w-full mt-4 divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr class="text-left text-sm font-semibold text-gray-600 uppercase">
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Nama</th>
        <th class="px-4 py-2">Spesialisasi</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      @foreach(\$healthWorkers as \$hw)
        <tr>
          <td class="px-4 py-2">{{ \$hw->id }}</td>
          <td class="px-4 py-2">{{ \$hw->name }}</td>
          <td class="px-4 py-2">{{ \$hw->specialty }}</td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('health-workers.edit', \$hw) }}"
               class="text-indigo-600 hover:underline">Edit</a>
            <form action="{{ route('health-workers.destroy', \$hw) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
'@

    'create.blade.php' = @'
{{-- resources/views/health-workers/create.blade.php --}}
@extends("layouts.app")

@section("title","Tambah Tenaga Kesehatan")

@section("content")
<div class="max-w-2xl mx-auto space-y-6">
  <h2 class="text-2xl font-semibold">Tambah Tenaga Kesehatan</h2>
  <form action="{{ route('health-workers.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}"
             class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('name')<p class="text-xs text-red-600">{{\$message}}</p>@enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
      <input type="text" name="specialty" value="{{ old('specialty') }}"
             class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('specialty')<p class="text-xs text-red-600">{{\$message}}</p>@enderror
    </div>

    <div class="text-right">
      <button type="submit"
              class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Simpan
      </button>
    </div>
  </form>
</div>
@endsection
'@

    'edit.blade.php' = @'
{{-- resources/views/health-workers/edit.blade.php --}}
@extends("layouts.app")

@section("title","Edit Tenaga Kesehatan")

@section("content")
<div class="max-w-2xl mx-auto space-y-6">
  <h2 class="text-2xl font-semibold">Edit Tenaga Kesehatan</h2>
  <form action="{{ route('health-workers.update', \$healthWorker) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
    @csrf @method("PUT")

    <div>
      <label class="block text-sm font-medium text-gray-700">Nama</label>
      <input type="text" name="name" value="{{ old('name', \$healthWorker->name) }}"
             class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('name')<p class="text-xs text-red-600">{{\$message}}</p>@enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
      <input type="text" name="specialty" value="{{ old('specialty', \$healthWorker->specialty) }}"
             class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('specialty')<p class="text-xs text-red-600">{{\$message}}</p>@enderror
    </div>

    <div class="text-right">
      <button type="submit"
              class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Perbarui
      </button>
    </div>
  </form>
</div>
@endsection
'@
}

foreach ($name in $stubs.Keys) {
    $path = Join-Path $viewDir $name
    if (-not (Test-Path $path)) {
        Write-Host "✔ Membuat stub view: $path"
        $stubs[$name] | Out-File -Encoding UTF8 -FilePath $path
    } else {
        Write-Host "ℹ Stub view sudah ada: $path"
    }
}

Write-Host "🎉 Selesai membuat HealthWorker resource scaffold!"
