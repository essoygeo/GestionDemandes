@extends('layouts.app')
@section('title','modifier demande')
@section('content')

    <div class="d-flex justify-content-center align-items-center bg-light  mb-3">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de modification</h3>
            <form action="{{route('update.demandes',['demande'=>$demande->id])}}" method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-10 mb-3">
                        <label for="ressources" class="form-label">Ressources de la demande</label>
                        <select class="form-select" name="ressources[]" multiple>
                            @foreach($ressources as $ressource)
                                <option value="{{ $ressource->id }}"
                                        @if(in_array($ressource->id, $ressourcesActuelles)) selected @endif>
                                    {{ $ressource->nom }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Utilisez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs ressources.</small>
                    </div>

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
                               id="estimation_montant" placeholder="Saisir montant en FCFA" value="{{old('estimation_montant',$demande->estimation_montant)}}">
                    </div>
                    <input type="hidden" name="no_estimation" value="0">
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input "  name="no_estimation" type="checkbox" id="no_estimation" {{$demande->estimation_montant=== null ? 'checked' : ''}} value="1">
                            <label class="form-check-label " for="no_estimation" >
                                Je ne peux pas faire d'estimation de montant
                            </label>
                        </div>
                    </div>
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


        })

    </script>



@endsection
