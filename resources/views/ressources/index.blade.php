@extends('layouts.app')
@section('title','Liste des ressources')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-3">Liste des ressources</h5>
            {{--            <a class="mb-0 btn btn-sm btn-outline-success " href="{{route('create.categories')}}">+ Creer categorie</a>--}}
        </div>
        <div class="card-body">

            <div class="mb-3">
                <label for="searchInput">Rechercher:</label>
                <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
            </div>


            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-hover  align-middle" id="dataTable">
                    <thead class="table-light">
                    <tr>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">N°</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">
                            Creatueur
                        </th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Categorie
                        </th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Nom
                            ressouce
                        </th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Marque</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Model</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Date
                            creation
                        </th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">
                           estimation à la creation
                        </th>
{{--                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Demandes--}}
{{--                            associées--}}

{{--                        </th>--}}

                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ressources as $ressource)
                        <tr>
                            <td class="text-center align-middle">{{$ressource->id}}</td>
                            <td class="text-center align-middle">{{$ressource->user->nom}}</td>
                            <td class="text-center align-middle">{{$ressource->categorie->nom}}</td>
                            <td class="text-center align-middle">{{$ressource->nom}}</td>
                            <td class="text-center align-middle">
                                @if(in_array(strtolower($ressource->categorie->nom), ['logicielle','logiciel','logicielles','logiciels']))
                                    <small class="text-primary-emphasis">pas de model</small>
                                @else
                                    {{$ressource->marque}}
                                @endif

                            </td>
                            <td class="text-center align-middle">
                                @if(in_array(strtolower($ressource->categorie->nom), ['logicielle','logiciel','logicielles','logiciels']))
                                    <small class="text-primary-emphasis">pas de marque</small>
                                @else
                                    {{$ressource->model}}
                                @endif

                            </td>
                            <td class="text-center align-middle">{{$ressource->created_at->format('y/m/d')}}</td>
                            <td class="text-center align-middle">
                                @if(isset( $ressource->estimation_montant))
                                    {{$ressource->estimation_montant}} CFA
                                @else
                                    <small class="text-primary-emphasis">Aucune estimation </small>
                                @endif

                            </td>
{{--                            <td class="text-center align-middle">--}}
{{--                                @if($ressource->demandes->isEmpty())--}}
{{--                                    <small class="text-primary-emphasis">Aucune demande associée</small>--}}
{{--                                @else--}}
{{--                                    @foreach($ressource->demandes as $demande)--}}
{{--                                        <span>{{ $demande->titre }} </span>--}}
{{--                                        @if(!$loop->last)--}}
{{--                                            <span> | </span>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}

{{--                            </td>--}}
                            <td class="text-center align-middle">
                                <div class="dropup">
                                    <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#showRessourceModal{{$ressource->id}}">
                                                <i class="fa-solid fa-eye me-1 text-success"></i> Voir
                                            </a>
                                        </li>
{{--                                        @if(Auth::user()->role ==='Admin')--}}
{{--                                            <li>--}}
{{--                                                <form action="{{ route('destroy.ressources',  $ressource->id) }}"--}}
{{--                                                      method="POST"--}}
{{--                                                      onsubmit="return confirm('Supprimer cette ressource ?');">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    <button class="dropdown-item text-danger" type="submit">--}}
{{--                                                        <i class="fas fa-trash-alt me-1"></i> Supprimer--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="showRessourceModal{{ $ressource->id }}" tabindex="-1"
                             aria-labelledby="showRessourceModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header bg-success-subtle">
                                        <h5 class="modal-title" id="voirRessourceModalLabel">Détails de la
                                            ressource</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Fermer"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div>
                                            <h3 class="text-center mb-4">Details ressource {{$ressource->nom}}
                                            </h3>

                                            <div>
                                                <form>

                                                    <div class="mb-3">
                                                        <label for="categorie_id" class="form-label">Catégorie de la
                                                            Ressource</label>
                                                        <select class="form-select " id="categorie_id"
                                                                name="categorie_id"
                                                                disabled>
                                                            @foreach($categories as $categorie)
                                                                <option
                                                                    value="{{ $categorie->id }}" {{ $ressource->categorie_id == $categorie->id ? 'selected' : '' }}>
                                                                    {{ $categorie->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="date_ressource" class="form-label">Date
                                                                création</label>
                                                            <input type="text" class="form-control"
                                                                   name="date_ressource"
                                                                   id="date_ressource"
                                                                   value="{{$ressource->created_at->format('y/m/d')}}" readonly>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label for="nom" class="form-label">Nom de la
                                                                ressource</label>
                                                            <input type="text" class="form-control" name="nom"
                                                                   id="nom"
                                                                   value="{{ $ressource->nom }}" readonly>
                                                        </div>
                                                    </div>

                                                    @if(in_array(strtolower($ressource->categorie->nom), ['materiel', 'materielles','materielle','materiels']))
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3" id="marque_div">
                                                                <label for="marque" class="form-label">Marque de la
                                                                    ressource
                                                                    matérielle</label>
                                                                <input type="text" class="form-control"
                                                                       name="marque"
                                                                       id="marque"
                                                                       value="{{ $ressource->marque }}" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3" id="model_div">
                                                                <label for="model" class="form-label">Modèle de la
                                                                    ressource
                                                                    matérielle</label>
                                                                <input type="text" class="form-control" name="model"
                                                                       id="model"
                                                                       value="{{ $ressource->model }}" readonly>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="estimation_montant" class="form-label">Estimation
                                                                de la ressource à la creation</label>
                                                            <input type="text" name="estimation_montant" id="estimation_montant"
                                                                   class="form-control"
                                                                   value="{{$ressource->estimation_montant === null ? 'Aucune estimation' : $ressource->estimation_montant }}"
                                                                   readonly>


                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center pagin mt-3">
                    {{ $ressources->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#dataTable tbody tr');

            searchInput.addEventListener('input', function () {
                const searchValue = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchValue) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
