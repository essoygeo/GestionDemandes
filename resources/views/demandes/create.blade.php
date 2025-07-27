@extends('layouts.app')
@section('title','Créer une demande')

@section('content')

    <div class="container py-4">
        {{-- Formulaire de Ressource --}}
        <div class="card shadow p-4">

            <h3 class="text-center mb-4"> Formulaire de creation de ressource</h3>

            <div class="card-body">
                <form method="POST" action="{{ route('store.ressources') }}">
                    @csrf


                    <div class="  mb-3">
                        <label for="categorie_id" class="form-label">Catégorie de la Ressource</label>
                        <select class="form-select" id="categorie_id" name="categorie_id">
                            <option selected>Choisissez une catégorie de ressource</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_ressource" class="form-label">Date création</label>
                            <input type="date" class="form-control" name="date_ressource" id="date_ressource" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom de la ressource</label>
                            <input type="text" class="form-control" name="nom" id="nom"
                                   placeholder="Saisir nom ressource" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3" id="marque_div">
                            <label for="marque" class="form-label">Marque de la ressource matérielle</label>
                            <input type="text" class="form-control" name="marque" id="marque"
                                   placeholder="Saisir marque">
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


        {{-- Séparateur --}}
        <hr class="my-5">


        {{-- Formulaire de Demande --}}
        <div class="card shadow p-4">

            <h3 class="text-center mb-4"> Formulaire de creation de demande</h3>

            <div class="card-body">
                <form method="POST" action="{{ route('store.demandes') }}">
                    @csrf
                    <div class="row">
                        <div class="  col-md-10 mb-3">
                            <label for="ressources[]" class="form-label">Ressource de la demande</label>
                            <select class="form-select" name="ressources[]">
                                <option selected>Choisissez la ressource</option>
                                @foreach($ressources as $ressource)
                                    <option value="{{ $ressource->id }}">{{ $ressource->nom }}</option>
                                @endforeach

                            </select>


                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end p-0">
                            <a class="btn btn-success " id="addRessource"><i class="fas fa-plus"></i></a>
                        </div>
                        <div id="ressource-container"></div>
                    </div>
                    <div class="row">
                        <div class=" col-md-6 mb-3">
                            <label for="date" class="form-label">Date de création</label>
                            <input type="date" class="form-control" name="date" id="date"  value="{{old('date')}}" required>
                        </div>

                            <div class=" col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre de la demande</label>
                                <input type="text" class="form-control" name="titre" id="titre"
                                       placeholder="Saisir le titre"  value="{{old('titre')}}" required>
                            </div>



                    <div class="row mb-3">

{{--                        <div class=" col-md-6 mb-3">--}}
{{--                            <label for="type" class="form-label">Type de demande</label>--}}
{{--                            <select class="form-select" id="type" name="type">--}}
{{--                                <option value="">Choisir un type de demande</option>--}}
{{--                                <option value="Achat" {{ old('type') == 'Achat' ? 'selected' : '' }}>Achat</option>--}}
{{--                                <option value="En stock" {{ old('type') == 'En stock' ? 'selected' : '' }}>En stock</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

                        <div class="col-md-6" id="estimation_montant_div">
                            <label for="estimation_montant" class="form-label">Coût estimé de la demande</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="estimation_montant"
                                   id="estimation_montant" placeholder="Saisir montant en FCFA" value="{{old('estimation_montant')}}">
                        </div>
                        <input type="hidden" name="no_estimation" value="0">
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input "  name="no_estimation" type="checkbox" id="no_estimation" value="1">
                                <label class="form-check-label " for="no_estimation">
                                    Je ne peux pas faire d'estimation de montant
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class=" mb-3">
                        <label for="raison" class="form-label">Raison de la demande</label>
                        <textarea class="form-control" rows="4" id="raison" name="raison"
                                  placeholder="Entrez la raison de la demande ici..." required>{{old('raison')}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Créer</button>
                </form>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // EstimationScript
            const check = document.getElementById('no_estimation');
            const estimationDiv = document.getElementById('estimation_montant_div');
            const estimationInput = document.getElementById('estimation_montant');

            function toggleEstimation() {
                if (check.checked ) {
                    estimationDiv.style.display = 'none';
                    estimationInput.value = '';
                } else {
                    estimationDiv.style.display = 'block';
                }
            }

            check.addEventListener('change', toggleEstimation);
            toggleEstimation();

            // categorieScript
            const categselect = document.getElementById('categorie_id');
            const model_div = document.getElementById('model_div');
            const marque_div = document.getElementById('marque_div');
            const marque = document.getElementById('marque');
            const model = document.getElementById('model');

            function toggleCategorieFields() {
                 const option = categselect.options[categselect.selectedIndex].text.toLowerCase();
                   const valeurs = ['logiciel', 'logicielles','logicielle','logiciels'];
                if (valeurs.includes(option)) {
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

            categselect.addEventListener('change', toggleCategorieFields);
            toggleCategorieFields();
        });
        //add ressource
        const addBtn = document.getElementById('addRessource');
        const container = document.getElementById('ressource-container');

        let ressourceIndex = 1;

        addBtn.addEventListener('click', function () {
            const selectBlock = `
        <div class="row" id="ressource-row-${ressourceIndex}">
            <div class="col-md-10 mb-3">
                <select class="form-select" name="ressources[]">
                    <option selected>Choisissez la ressource</option>
                    @foreach($ressources as $ressource)
            <option value="{{ $ressource->id }}">{{ $ressource->nom }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-md-2 mb-3 d-flex  p-0 align-items-end">
            <button type="button" class="btn btn-danger removeRessource" data-id="${ressourceIndex}">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    `;
            container.insertAdjacentHTML('beforeend', selectBlock)
            ressourceIndex++;

            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRessource') || e.target.closest('.removeRessource')) {
                    const button = e.target.closest('.removeRessource');
                    const id = button.getAttribute('data-id');
                    const row = document.getElementById(`ressource-row-${id}`);
                    row.remove();
                }
            })


        })

    </script>

@endsection
