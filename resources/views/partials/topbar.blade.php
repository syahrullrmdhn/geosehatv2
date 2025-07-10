<header class="fixed top-0 left-0 right-0 h-16 px-6 bg-white border-b border-gray-200 flex items-center z-20">
  <button id="sidebar-toggle" class="lg:hidden mr-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <x-heroicon-o-bars-3 class="h-6 w-6 text-gray-500"/>
  </button>
  <h1 class="text-xl font-semibold text-gray-900">
    @yield('title', 'Dashboard GeoSehat')
  </h1>
  <div class="ml-auto flex items-center space-x-4">
    <button class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full" aria-label="View notifications">
      <x-heroicon-o-bell class="h-6 w-6"/>
      @if(auth()->user()->unreadNotifications()->count() > 0)
        <span class="absolute top-0 right-0 block h-2.5 w-2.5 bg-red-500 rounded-full ring-2 ring-white"></span>
      @endif
    </button>
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full"/>
        <span class="text-gray-700">{{ auth()->user()->name }}</span>
        <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-500"/>
      </button>
      <div x-show="open" @click.away="open = false" x-transition
           class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20"
           x-cloak>
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          Profil Anda
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Keluar
          </button>
        </form>
      </div>
    </div>
  </div>
</header>