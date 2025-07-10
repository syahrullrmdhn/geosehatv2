@props([
    'route',
    'icon',
    'title',
    'active' => false,
    'badge'  => null,
])

<a href="{{ route($route) }}"
   class="{{ $active 
              ? 'bg-indigo-50 text-indigo-700' 
              : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}
          flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors">
    <x-heroicon-o-{{ $icon }} 
      class="{{ $active 
                 ? 'text-indigo-600' 
                 : 'text-gray-400 group-hover:text-gray-700' }} 
             mr-3 h-5 w-5 flex-shrink-0" />
    <span class="flex-1">{{ $title }}</span>
    @if($badge && $badge > 0)
        <span class="inline-flex items-center justify-center ml-2 px-2 py-0.5 text-xs font-semibold text-white bg-red-500 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>
