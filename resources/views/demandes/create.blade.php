@extends('layouts.app')
@section('title','Créer une demande et ses ressources')

@section('content')

    <div class="container py-4">

        {{-- Formulaire de Demande --}}
        <div class="card shadow p-4">

            <h3 class="text-center mb-4"> Formulaire de creation de demande</h3>

            <div class="card-body">
                <form method="POST" action="{{ route('store.demandes') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="categorie_id" class="form-label">Catégorie de la demande</label>
                        <select class="form-select" id="categorie_id" name="categorie_id">
                            <option selected>Choisissez une catégorie de demande</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre de la demande</label>
                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Saisir le titre" required>
                    </div>

                    <div class="mb-3">
                        <label for="raison" class="form-label">Raison de la demande</label>
                        <textarea class="form-control" rows="4" id="raison" name="raison" placeholder="Entrez la raison de la demande ici..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type de demande</label>
                        <select class="form-select" id="type" name="type">
                            <option selected>Choisir un type de demande</option>
                            <option value="Achat">Achat</option>
                            <option value="En stock">En stock</option>
                        </select>
                    </div>

                    <div class="mb-3" id="estimation_montant_div">
                        <label for="estimation_montant" class="form-label">Coût estimé de la demande</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="estimation_montant" id="estimation_montant" placeholder="Saisir montant en FCFA">
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date de création</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Créer</button>
                </form>
            </div>
        </div>

        {{-- Séparateur --}}
        <hr class="my-5">

        {{-- Formulaire de Ressource --}}
        <div class="card shadow p-4">

            <h3 class="text-center mb-4"> Formulaire de creation de ressource</h3>

            <div class="card-body">
                <form method="POST" action="{{ route('store.ressources') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="demande_id" class="form-label">Demande associée</label>
                        <select class="form-select" id="demande_id" name="demande_id">
                            <option selected>Choisissez une demande</option>
                            @foreach($demandes as $dm)
                                <option data-categorie="{{ $dm->categorie->nom ?? '' }}"
                                        value="{{ $dm->id }}"
                                    {{ isset($demandeSelectione) && $demandeSelectione->id == $dm->id ? 'selected' : '' }}>
                                    {{ $dm->titre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date création</label>
                            <input type="date" class="form-control" name="date_ressource" id="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom de la ressource</label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Saisir nom ressource" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3" id="marque_div">
                            <label for="marque" class="form-label">Marque de la ressource matérielle</label>
                            <input type="text" class="form-control" name="marque" id="marque" placeholder="Saisir marque">
                        </div>
                        <div class="col-md-6 mb-3" id="model_div">
                            <label for="model" class="form-label">Modèle de la ressource matérielle</label>
                            <input type="text" class="form-control" name="model" id="model" placeholder="Saisir modèle">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // EstimationScript
            const typeSelect = document.getElementById('type');
            const estimationDiv = document.getElementById('estimation_montant_div');
            const estimationInput = document.getElementById('estimation_montant');

            function toggleEstimation() {
                if (typeSelect.value === 'En stock') {
                    estimationDiv.style.display = 'none';
                    estimationInput.value = '';
                } else {
                    estimationDiv.style.display = 'block';
                }
            }

            typeSelect.addEventListener('change', toggleEstimation);
            toggleEstimation();

            // categorieScript
            const select = document.getElementById('demande_id');
            const model_div = document.getElementById('model_div');
            const marque_div = document.getElementById('marque_div');
            const marque= document.getElementById('marque');
            const model = document.getElementById('model');

            function toggleCategorieFields() {
                const dmSelect = select.options[select.selectedIndex];
                const typeCateg = dmSelect.getAttribute('data-categorie');

                if (typeCateg && typeCateg.toLowerCase() === 'logicielles') {
                    model_div.style.display = 'none';
                    marque_div.style.display = 'none';
                    model.value = '';
                    marque.value = '';
                    model.disabled = true;
                    marque.disabled = true;
                } else {
                    model_div.style.display = 'block';
                    marque_div.style.display = 'block';
                    model.disabled = false;
                    marque.disabled = false;
                }
            }

            select.addEventListener('change', toggleCategorieFields);
            toggleCategorieFields();
        });

    </script>

@endsection
