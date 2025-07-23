@extends('layouts.app')

@section('title','Notifikasi & Log Aktivitas GeoSehat')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Notifikasi & Log Aktivitas</h2>

  <div class="bg-white p-4 rounded shadow">

    {{-- Tab --}}
    <div class="mb-4 flex gap-3 border-b">
      <button x-data x-on:click="document.getElementById('tab1').classList.remove('hidden');document.getElementById('tab2').classList.add('hidden');document.getElementById('tab3').classList.add('hidden')" class="py-2 px-4 border-b-2 font-medium">Notifikasi</button>
      <button x-data x-on:click="document.getElementById('tab1').classList.add('hidden');document.getElementById('tab2').classList.remove('hidden');document.getElementById('tab3').classList.add('hidden')" class="py-2 px-4 border-b-2 font-medium">Aktivitas</button>
      <button x-data x-on:click="document.getElementById('tab1').classList.add('hidden');document.getElementById('tab2').classList.add('hidden');document.getElementById('tab3').classList.remove('hidden')" class="py-2 px-4 border-b-2 font-medium">Threshold Alerts</button>
    </div>

    {{-- Notifikasi Tab --}}
    <div id="tab1">
      @if($notifications->count())
        <ul class="divide-y">
          @foreach($notifications as $n)
            <li class="py-3 flex justify-between items-start">
              <div>
                {!! $n->data['message'] ?? '<em>(Tidak ada pesan)</em>' !!}
                <div class="text-xs text-gray-500 mt-1">
                  {{ $n->created_at->diffForHumans() }}
                </div>
              </div>
              @if(is_null($n->read_at))
                <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-blue-600 hover:underline text-sm">
                    Tandai sudah dibaca
                  </button>
                </form>
              @endif
            </li>
          @endforeach
        </ul>
        <div class="mt-4">
          {{ $notifications->links() }}
        </div>
      @else
        <p class="text-gray-600">Anda tidak memiliki notifikasi.</p>
      @endif
    </div>

    {{-- Aktivitas Tab --}}
    <div id="tab2" class="hidden">
      @if(isset($activityLogs) && $activityLogs->count())
        <ul class="divide-y">
          @foreach($activityLogs as $log)
            <li class="py-3 flex justify-between items-start">
              <div>
                <span class="font-medium text-gray-800">{{ $log->user_name ?? '-' }}</span>
                <span class="text-gray-600">{{ $log->activity }}</span>
                <div class="text-xs text-gray-500 mt-1">
                  {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-gray-600">Belum ada log aktivitas.</p>
      @endif
    </div>

    {{-- Threshold Alerts Tab --}}
    <div id="tab3" class="hidden">
      @if(isset($thresholdNotifications) && $thresholdNotifications->count())
        <ul class="divide-y">
          @foreach($thresholdNotifications as $n)
            <li class="py-3 flex justify-between items-start">
              <div>
                <span class="font-bold text-red-600">[THRESHOLD]</span>
                {!! $n->data['message'] ?? '<em>(Tidak ada pesan)</em>' !!}
                <div class="text-xs text-gray-500 mt-1">
                  {{ $n->created_at->diffForHumans() }}
                </div>
              </div>
              @if(is_null($n->read_at))
                <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-blue-600 hover:underline text-sm">
                    Tandai sudah dibaca
                  </button>
                </form>
              @endif
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-gray-600">Tidak ada threshold alert terbaru.</p>
      @endif
    </div>
  </div>
@endsection
