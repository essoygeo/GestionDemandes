@extends('templates.dashboard')
@section('title','Commentaires')

@section('content')
    <div class="container mt-4">

        <h3 class="text-center mb-5">
            Commentaires de la demande <span class="text-violet">{{ $demande->titre }}</span>
        </h3>

        {{-- Liste des commentaires --}}
        <div class="mb-5">
            @forelse($demande->commentaires as $commentaire)
                <div class="card mb-3 shadow-sm ">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong>{{ $commentaire->user->nom }}</strong>
                        </div>
                        <small class="text-muted">{{ $commentaire->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $commentaire->contenu }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    Aucun commentaire pour cette demande.
                </div>
            @endforelse
        </div>


        <div class="card shadow">
            <div class="card-header bg-violet text-white">
                Ajouter un commentaire
            </div>
            <div class="card-body">
                <form action="{{ route('store.commentaires', $demande->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="contenu" class="form-control" rows="4" placeholder="Écrivez votre commentaire ici..." required>{{ old('contenu') }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-outline-violet">Publier</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
