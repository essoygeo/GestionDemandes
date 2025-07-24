@extends('layouts.app')
@section('title','modifier demande')
@section('content')

    <div class="d-flex justify-content-center align-items-center bg-light  mb-3">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de modification</h3>
            <form action="{{route('update.demandes',['demande'=>$demande->id])}}" method="post">
                @csrf
                @method('PUT')


                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Catégorie</label>
                    <select class="form-select" id="categorie_id" name="categorie_id" required>
                        <option disabled>Choisissez une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                {{ $demande->categorie_id == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de la demande </label>
                    <input type="text" class="form-control" name="titre" id="titre" value="{{$demande->titre}}">
                </div>

                <div class="mb-3">
                    <label for="raison" class="form-label">Raison de la demande</label>
                    <textarea
                        class="form-control"
                        rows="4"
                        id="raison"
                        name="raison"
                    >{{$demande->raison}}</textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" name="type" id="type">
                        <option  value="Achat"{{$demande->type==='Achat' ? 'selected' : ''}}>Achat</option>
                        <option  value="En stock"{{$demande->type==='En stock' ? 'selected' : ''}}>En stock</option>

                    </select>
                </div>

                <div class="mb-3" id="estimation_montant_div">
                    <label for="estimation_montant" class="form-label">Coût estimé de la demande </label>
                    <input type="number" step="0.01" min="0" class="form-control" name="estimation_montant"
                           id="estimation_montant" value="{{$demande->estimation_montant}}" >
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date de creation</label>
                    <input type="date"  class="form-control" name="date"
                           id="date"  value="{{$demande->date}}">
                </div>

                <button type="submit"  class="btn  btn-success w-100" href="{{route('index.demandes')}}">
                    modifier
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
