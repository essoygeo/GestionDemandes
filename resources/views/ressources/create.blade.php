@extends('templates.dashboard')
@section('title','creer une ressource')
@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de creation</h3>

            <form method="POST" action="{{ route('store.ressources') }}">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" id="demande_id"
                                name="demande_id" >
                            <option  selected>Choisissez une  demande</option>
                            @foreach($demandes as $dm)
                                <option  data-categorie="{{$dm->categorie->nom ?? ''}}" value="{{$dm->id}}"{{isset ($demandeSelectione)&& $demandeSelectione->id == $dm->id ?  'selected' : ''}}>{{$dm->titre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date creation</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la ressource</label>
                            <input type="text" class="form-control" name="nom" id="nom"
                                   placeholder="saisir nom ressource" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6"  >
                        <div class="mb-3" id="marque_div">
                            <label for="marque" class="form-label">Marque de la ressource materielle</label>
                            <input type="text" class="form-control" name="marque" id="marque"
                                   placeholder="saisir marque ressource materielle" >
                        </div>
                    </div>
                    <div class="col-6" >
                        <div class="mb-3" id="model_div">
                            <label for="model" class="form-label">Model de la ressource materielle</label>
                            <input type="text" class="form-control" name="model" id="model"
                                   placeholder="saisir model ressource materielle">
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn  btn-violet w-100">
                    creer
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const select = document.getElementById('demande_id');
            const model_div = document.getElementById('model_div');
            const marque_div = document.getElementById('marque_div');
            const marque= document.getElementById('marque');
            const model = document.getElementById('model');

            function toggleEstimation() {
                const dmSelect = select.options[select.selectedIndex]
                const typeCateg = dmSelect.getAttribute('data-categorie');

                if (typeCateg.toLowerCase() == 'logicielles') {
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

        select.addEventListener('change', toggleEstimation);

            toggleEstimation();
        });
    </script>

@endsection
