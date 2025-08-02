@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-center text-success">Toutes mes notifications</h1>

        @if($notifications->isEmpty())
            <div class="alert alert-info text-center">
                Vous n'avez aucune notification pour le moment.
            </div>
        @else
            <div class="list-group">
                @foreach($notifications as $notif)
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                    @if(!$notif->is_read) fw-bold bg-white @else text-muted @endif"
                        >
                        <div>
                            <p class="mb-1">{{ $notif->message }}</p>
                            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            @if(!$notif->is_read)
                                <span class="badge bg-success rounded-pill">Nouveau</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{-- Pagination --}}
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <div class="mt-4 d-flex justify-content-between">
            <form action="{{ route('notifications.clear') }}" method="POST" >
                @csrf
                <button type="submit" class="btn btn-sm btn-success w-100">
                    Marquer comme lu
                </button>
            </form>

{{--            <form action="{{ route('notifications.deleteAll') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications ?')">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}
{{--                <button type="submit" class="btn btn-outline-secondary">--}}
{{--                    Supprimer toutes les notifications--}}
{{--                </button>--}}
{{--            </form>--}}
        </div>
    </div>
@endsection
