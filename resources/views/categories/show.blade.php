@extends('layouts.app')
@section('title','details categorie')
@section('content')
    <div class=" d-flex justify-content-center align-items-center  bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"><span>Details de la categorie {{$categorie->nom}}</span>
            </h3>

            <form>
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom categorie</label>
                    <input type="text" class="form-control" name="nom" id="nom" value="{{$categorie->nom}}"
                           placeholder="saisir nom categorie" readonly>
                </div>
                <div class="mb-3">
                    <label for="createur" class="form-label">Createur</label>
                    <input type="text" class="form-control" name="createur" id="createur"
                           value="{{$categorie->user->nom}}" placeholder="saisir nom categorie" readonly>
                </div>
                <div class="mb-3">
                    <a href="javascript:history.back()" class="btn btn-success w-100">
                        <i class="fas fa-arrow-left"></i> retour
                    </a>
                </div>
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
