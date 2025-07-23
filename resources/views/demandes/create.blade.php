@extends('templates.dashboard')
@section('title','creer une demande')
@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de creation</h3>

            <form method="POST" action="{{ route('store.demandes') }}">
                @csrf
               <div class="mb-3">
                <select class="form-select" aria-label="Default select example" id="categorie_id" name="categorie_id">
                    <option selected>Choisissez une categorie de demande</option>
                    @foreach($categories as $categorie)
                        <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                    @endforeach
                </select>
               </div>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de la demande </label>
                    <input type="text" class="form-control" name="titre" id="titre" placeholder="saisir titre" required>
                </div>

                <div class="mb-3">
                    <label for="raison" class="form-label">Raison de la demande</label>
                    <textarea
                        class="form-control"
                        rows="4"
                        id="raison"
                        name="raison"
                        placeholder="Entrez la raison de la demande ici..."
                        required
                    ></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" name="type" id="type">
                        <option selected>Choisir un type de demande</option>
                        <option value="Achat">Achat</option>
                        <option value="En stock">En stock</option>

                    </select>
                </div>

                <div class="mb-3" id="estimation_montant_div">
                    <label for="estimation_montant" class="form-label">Coût estimé de la demande </label>
                    <input type="number" step="0.01" min="0" class="form-control" name="estimation_montant"
                           id="estimation_montant" placeholder="saisir montant en frcfa" >
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date de creation</label>
                    <input type="date"  class="form-control" name="date"
                           id="date" required>
                </div>

                <button type="submit" class="btn  btn-violet w-100">
                    creer
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>

@endsection
