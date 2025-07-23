<header class="fixed top-0 left-0 right-0 h-16 px-6 bg-white border-b border-gray-200 flex items-center z-30 shadow-sm">
  <!-- Mobile menu button -->
  <button id="sidebar-toggle" class="lg:hidden mr-4 p-1 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
    <x-heroicon-o-bars-3 class="h-6 w-6" />
    <span class="sr-only">Toggle sidebar</span>
  </button>

  <!-- Logo/Title -->
  <div class="flex items-center">
    <h1 class="text-xl font-semibold text-gray-900 tracking-tight">
      @yield('title', 'Dashboard GeoSehat')
    </h1>
  </div>

  <!-- Right side navigation -->
  <div class="ml-auto flex items-center space-x-4">
    <!-- Notifications -->
    <div x-data="{ open: false }" class="relative">
      <button
        @click="open = !open"
        class="p-1 rounded-full text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors relative"
        aria-label="Notifications"
      >
        <x-heroicon-o-bell class="h-6 w-6" />
        @if(auth()->user()->unreadNotifications()->count() > 0)
          <span class="absolute top-0 right-0 block h-2.5 w-2.5 bg-red-500 rounded-full ring-2 ring-white"></span>
        @endif
      </button>

      <!-- Notification dropdown -->
      <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 divide-y divide-gray-100"
        x-cloak
      >
        <div class="px-4 py-3">
          <p class="text-sm font-medium text-gray-900">Notifikasi</p>
        </div>
        <div class="py-1 max-h-96 overflow-y-auto">
          @forelse(auth()->user()->unreadNotifications()->take(5)->get() as $notification)
            <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <div class="flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                  <x-heroicon-o-bell-alert class="h-5 w-5 text-indigo-500" />
                </div>
                <div class="ml-3 flex-1">
                  <p class="text-gray-900">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                  <p class="mt-1 text-gray-500">{{ $notification->data['message'] ?? '' }}</p>
                  <p class="mt-1 text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
              </div>
            </a>
          @empty
            <div class="px-4 py-3 text-center text-sm text-gray-500">
              Tidak ada notifikasi baru
            </div>
          @endforelse
        </div>
        <div class="py-1">
          <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-indigo-600 hover:bg-gray-50 font-medium">
            Lihat Semua
          </a>
        </div>
      </div>
    </div>

    <!-- User profile dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button
        @click="open = !open"
        class="flex items-center space-x-2 max-w-xs rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors"
      >
        <img
          src="{{ auth()->user()->profile_photo_url }}"
          alt="{{ auth()->user()->name }}"
          class="h-8 w-8 rounded-full object-cover border border-gray-200"
        />
        <span class="hidden md:inline-block text-sm font-medium text-gray-700 truncate max-w-[120px]">
          {{ auth()->user()->name }}
        </span>
        <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-400" />
      </button>

      <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20 py-1"
        x-cloak
      >
        <a
          href="{{ route('profile.edit') }}"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
        >
          <div class="flex items-center">
            <x-heroicon-o-user class="h-5 w-5 text-gray-400 mr-2" />
            Profil Anda
          </div>
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button
            type="submit"
            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center"
          >
            <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5 text-gray-400 mr-2" />
            Keluar
          </button>
        </form>
      </div>
    </div>
  </div>
</header>
