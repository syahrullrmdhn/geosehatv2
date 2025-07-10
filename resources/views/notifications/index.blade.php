@extends('layouts.app')

@section('title','Notifikasi GeoSehat')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Notifikasi</h2>

  <div class="bg-white p-4 rounded shadow">
    @if($notifications->count())
      <ul class="divide-y">
        @foreach($notifications as $n)
          <li class="py-3 flex justify-between items-start">
            <div>
              {{-- misal payload data pesan --}}
              {!! $n->data['message'] ?? '<em>(Tidak ada pesan)</em>' !!}
              <div class="text-xs text-gray-500 mt-1">
                {{ $n->created_at->diffForHumans() }}
              </div>
            </div>
            @if(is_null($n->read_at))
              <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="text-blue-600 hover:underline text-sm">
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
@endsection
