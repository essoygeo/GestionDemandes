@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- DÉTAILS DE LA DEMANDE --}}
        <div class="card mb-4">
            <div class="card-header bg-success-subtle">Détails de la Demande</div>
            <div class="card-body row">

                <div class="col-md-6 mb-3">
                    <strong>Titre :</strong> {{ $demande->titre }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Type :</strong> {{ $demande->type }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Raison :</strong> {{ $demande->raison }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Coût estimé :</strong> {{  $demande->estimation_montant ? $demande->estimation_montant. 'CFA'   : 'pas de coût'  }}
                </div>
                <div class="col-md-12">
                    <strong>Statut :</strong> {{ $demande->status }}
                </div>
            </div>
        </div>

        {{-- TABLEAU DES RESSOURCES LIÉES À LA DEMANDE --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-3">Liste des ressources associées</h5>
                <a class="mb-0 btn btn-sm btn-outline-violet " href="{{route('create.demandes')}}">+ Creer demande</a>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="searchInput">Rechercher:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable">
                        <thead class="table-light">
                        <tr>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">N°</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Categorie</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Creatueur</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Titre demande</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Raison demande</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Type demande</th>

                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center pagin mt-3">
{{--                        {{ $demandes->links('pagination::bootstrap-5') }}--}}
                    </div>
                </div>
            </div>
        </div>

        {{-- COMMENTAIRES --}}
        <div class="card mb-4">
            <div class="card-header bg-success-subtle ">Commentaires</div>
            <div class="card-body">
                @forelse ($demande->commentaires as $commentaire)
                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ $commentaire->user->nom }}</strong> <br>
                        <span class="text-muted">{{ $commentaire->created_at->format('d/m/Y H:i') }}</span>
                        <p>{{ $commentaire->contenu }}</p>
                    </div>
                @empty
                    <p class="text-muted">Aucun commentaire pour cette demande.</p>
                @endforelse
            </div>
        </div>

        {{-- AJOUTER UN COMMENTAIRE --}}
        <div class="card mb-4">
            <div class="card-header bg-success-subtle">Ajouter un commentaire</div>
            <div class="card-body">
                <form action="{{ route('store.commentaires', $demande->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre commentaire</label>
                        <textarea name="contenu" id="contenu" class="form-control" rows="3" required></textarea>
                    </div>
                    <button class="btn btn-outline-secondary">Envoyer</button>
                </form>
            </div>
        </div>

    </div>
@endsection
