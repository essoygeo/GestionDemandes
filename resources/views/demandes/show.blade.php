@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- DÉTAILS DE LA DEMANDE --}}
        <div class="card mb-4">
            <div class="card-header bg-success-subtle d-flex justify-content-between align-items-center">
                Détails de la Demande
{{--                bouton de validation demande--}}
                @if($demande->status === 'En attente' && Auth::user()->role == 'Comptable')
                    <div>
                        <form action="{{ route('valider.demandes', ['demande'=>$demande->id]) }}" method="POST"
                              class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success me-2 rounded">
                                <i class="fa-solid fa-thumbs-up"></i>  Valider
                            </button>
                        </form>

                        <form action="{{ route('refuser.demandes', ['demande'=>$demande->id]) }}" method="POST"
                              class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger rounded">
                                <i class="fa-solid fa-xmark"></i> Refuser
                            </button>
                        </form>
                    </div>
                @endif

            </div>

            <div class="card-body row">

                <div class="col-md-6 mb-3">
                    <strong>Titre :</strong> {{ $demande->titre }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Raison :</strong> {{ $demande->raison }}
                </div>
                {{--                <div class="col-md-6 mb-3">--}}
                {{--                    <strong>Coût estimé:</strong>--}}
                {{--                    @if(isset($demande->estimation_montant))--}}
                {{--                        <span class="text-primary fw-semibold">{{ $demande->estimation_montant }} CFA</span>--}}
                {{--                    @else--}}
                {{--                        <strong class=" text-primary-emphasis">Aucune estimation définie</strong>--}}
                {{--                    @endif--}}

                {{--                </div>--}}
                <div class="col-md-6 mb-3">
                    <strong>Statut :</strong>
                    @if($demande->status === 'En attente')
                        <strong class="text-warning">{{ $demande->status }}</strong>
                    @elseif($demande->status === 'Refusé')
                        <strong class="text-danger">{{ $demande->status }}</strong>
                    @else
                        <strong class="text-success">{{ $demande->status }}</strong>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Date :</strong> {{$demande->created_at->format('y/m/d')}}
                </div>
                <div class="col-md-6 ">
                    <strong>Montant actuel de la caisse :</strong>


                    <span class=" badge bg-success  fw-semibold fs-6 ">{{ $caisse_mtn_actuel}} CFA</span>


                </div>
            </div>
        </div>

        {{-- TABLEAU DES RESSOURCES LIÉES À LA DEMANDE --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-3">Liste des ressources associées</h5>
                {{--                <a class="mb-0 btn btn-sm btn-outline-violet " href="{{route('create.demandes')}}">+ Creer demande</a>--}}
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="searchInput">Rechercher:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
                </div>

                <div class="table-responsive" style="overflow: visible">
                    <table class="table table-hover align-middle" id="dataTable">
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
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Coût
                                estimé
                            </th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Date
                                creation
                            </th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">
                                Status
                            </th>

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
                                    @if(strcasecmp($ressource->categorie->nom, 'logicielle') === 0)
                                        <small class="text-primary-emphasis">pas de marque</small>
                                    @else

                                        {{$ressource->marque  }}
                                    @endif

                                </td>
                                <td class="text-center align-middle">
                                    @if(strcasecmp($ressource->categorie->nom, 'logicielle') === 0)
                                        <small class="text-primary-emphasis">pas de model</small>
                                    @else
                                        {{$ressource->model  }}
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if(isset( $ressource->estimation_montant))
                                        {{$ressource->estimation_montant}} CFA
                                    @else
                                        <small class="text-primary-emphasis">Aucune estimation </small>
                                    @endif

                                </td>
                                <td class="text-center align-middle">{{$ressource->created_at->format('y/m/d')}}</td>
                                <td class="text-center align-middle">
                                    @if($ressource->status === 'A payer')
                                        <span class="badge bg-warning"> {{$ressource->status}}</span>
                                    @elseif($ressource->status === 'Payer')
                                        <span class="badge bg-success"> {{$ressource->status}}</span>
                                    @elseif($ressource->status === 'En stock')
                                        <span class="badge bg-primary"> {{$ressource->status}}</span>
                                    @else
                                        <span class="badge bg-danger"> {{$ressource->status}}</span>
                                    @endif

                                </td>
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
                                            @if(Auth::user()->role === 'Admin'||Auth::user()->role === 'employe')
                                                @if($demande->status === 'En attente')
                                                    <li>
                                                        <a class="dropdown-item "
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#editRessourceModal{{$ressource->id}}">
                                                            <i class="fas fa-edit me-1 text-success"></i> Modifier
                                                        </a>
                                                    </li>
                                                    {{--                                                    <li>--}}
                                                    {{--                                                        <form--}}
                                                    {{--                                                            action="{{ route('destroy.ressources',  $ressource->id) }}"--}}
                                                    {{--                                                            method="POST"--}}
                                                    {{--                                                            onsubmit="return confirm('Supprimer cette ressource ?');">--}}
                                                    {{--                                                            @csrf--}}
                                                    {{--                                                            @method('DELETE')--}}
                                                    {{--                                                            <button class="dropdown-item text-danger" type="submit">--}}
                                                    {{--                                                                <i class="fas fa-trash-alt me-1"></i> Supprimer--}}
                                                    {{--                                                            </button>--}}
                                                    {{--                                                        </form>--}}
                                                    {{--                                                    </li>--}}

                                                @endif

                                            @else
                                                <li>


                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#editMontant{{$ressource->id}}">
                                                        <i class="fa-solid fa-edit text-success"></i> modifier
                                                        montant
                                                    </button>


                                                </li>

                                                <li>
                                                    <form
                                                        action="{{route('changestatus.ressources',['ressource'=>$ressource->id])}}"
                                                        method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <input type="hidden" name="nouveau_status" value="Payer">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa-solid fa-check text-success"></i> Payer
                                                        </button>
                                                    </form>

                                                </li>
                                                <li>
                                                    <form
                                                        action="{{route('changestatus.ressources',['ressource'=>$ressource->id])}}"
                                                        method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <input type="hidden" name="nouveau_status" value="En stock">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa-solid fa-box text-primary"></i> En stock
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{route('changestatus.ressources',['ressource'=>$ressource->id])}}"
                                                        method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <input type="hidden" name="nouveau_status"
                                                               value="Ne sera pas payé">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa-solid fa-xmark text-danger"></i> Ne sera pas payé
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {{-- modal de show ressorce--}}
                            <!-- Modal -->
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
                                                                       value="{{ $ressource->created_at->format('y/m/d') }}"
                                                                       readonly>
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
                                                                    de la ressource</label>
                                                                <input type="text" name="estimation_montant"
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
                            {{--modal editRessource--}}
                            <div class="modal fade" id="editRessourceModal{{ $ressource->id }}" tabindex="-1"
                                 aria-labelledby="editRessourceModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header bg-success-subtle">
                                            <h5 class="modal-title" id="editRessourceModalLabel">Formulaire de
                                                modification de la
                                                ressource</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Fermer"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div>
                                                <h3 class="text-center mb-4">Modifier ressource {{$ressource->nom}}
                                                </h3>

                                                <div>
                                                    <form
                                                        action="{{route('update.ressources',['ressource'=>$ressource->id])}}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="categorie_id" class="form-label">Catégorie de la
                                                                Ressource</label>
                                                            <select class="form-select categorie-select"
                                                                    data-id="{{$ressource->id}}"
                                                                    name="categorie_id"
                                                            >
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
                                                                <input type="date" class="form-control"
                                                                       name="date_ressource"
                                                                       id="date_ressource"
                                                                       value="{{ $ressource->created_at->format('y/m/d') }}">
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label for="nom" class="form-label">Nom de la
                                                                    ressource</label>
                                                                <input type="text" class="form-control" name="nom"
                                                                       id="nom"
                                                                       value="{{ $ressource->nom }}">
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6 mb-3"
                                                                 id="marque_div{{$ressource->id}}">
                                                                <label for="marque" class="form-label">Marque de la
                                                                    ressource
                                                                    matérielle</label>
                                                                <input type="text" class="form-control"
                                                                       name="marque"
                                                                       id="marque{{$ressource->id}}"
                                                                       value="{{ $ressource->marque }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3" id="model_div{{$ressource->id}}">
                                                                <label for="model" class="form-label">Modèle de la
                                                                    ressource
                                                                    matérielle</label>
                                                                <input type="text" class="form-control" name="model"
                                                                       id="model{{$ressource->id}}"
                                                                       value="{{ $ressource->model }}">
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
                                                                    <label for="estimation_montant" class="form-label">Coût
                                                                        estimé de la ressource</label>
                                                                    <input type="number" step="0.01" min="0"
                                                                           class="form-control"
                                                                           name="estimation_montant"
                                                                           id="estimation_montant"
                                                                           placeholder="Saisir montant en FCFA"
                                                                           value="{{$ressource->estimation_montant }}">

                                                                </div>
                                                                <input type="hidden" name="no_estimation" value="0">
                                                                <div class="col-md-6 d-flex align-items-end">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input "
                                                                               name="no_estimation" type="checkbox"
                                                                               id="no_estimation"
                                                                               {{$ressource->estimation_montant=== null ? 'checked' : ''}} value="1">
                                                                        <label class="form-check-label "
                                                                               for="no_estimation">
                                                                            Je ne peux pas faire d'estimation de montant
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <button type="submit" class="btn btn-success w-100">modifier
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{--modal editMontantRessource--}}
                            <div class="modal fade" id="editMontant{{ $ressource->id }}" tabindex="-1"
                                 aria-labelledby="editMontant" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header bg-success-subtle">
                                            <h5 class="modal-title" id="editMontant">Formulaire de modification de
                                                montant

                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Fermer"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div>
                                                <h3 class="text-center mb-4">Modifier montant
                                                    ressource {{$ressource->nom}}
                                                </h3>

                                                <div>
                                                    <form
                                                        action="{{route('updatemontant.ressources',['ressource'=>$ressource->id])}}"
                                                        method="POST">
                                                        @method('PATCH')
                                                        @csrf


                                                        <div class="row mb-3">

                                                            <div class=id="estimation_montant_div">
                                                                <label for="estimation_montant" class="form-label">
                                                                    Montant de la ressource</label>
                                                                <input type="number" step="0.01" min="0"
                                                                       class="form-control"
                                                                       name="estimation_montant"
                                                                       id="estimation_montant"
                                                                       placeholder="Saisir montant en FCFA"
                                                                       value="{{$ressource->estimation_montant }}"
                                                                       required>

                                                            </div>


                                                        </div>


                                                        <button type="submit" class="btn btn-success w-100">modifier
                                                        </button>
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
                    <strong>Montant total des ressources :</strong>
                    <span class=" badge bg-primary  fw-semibold fs-6 ">{{ $montantRessources}} CFA</span>
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
                        <span class="text-muted">{{ $commentaire->created_at->format('d/m/Y H:i') }}</span>
                        <br>
                        <strong>{{ $commentaire->user->nom }}</strong>

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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
                const selects = document.querySelectorAll('.categorie-select');

                selects.forEach(select => {
                    const id = select.dataset.id;
                    const marque_div = document.getElementById(`marque_div${id}`);
                    const model_div = document.getElementById(`model_div${id}`);

                    function toggleFields() {
                        const selected = select.options[select.selectedIndex].text.toLowerCase();
                        if (selected === 'logicielle') {
                            marque_div.style.display = 'none';
                            model_div.style.display = 'none';
                        } else {
                            marque_div.style.display = 'block';
                            model_div.style.display = 'block';
                        }
                    }

                    toggleFields();
                    select.addEventListener('change', toggleFields);

                });


                // / EstimationScript
                const check = document.getElementById('no_estimation');
                const estimationDiv = document.getElementById('estimation_montant_div');
                const estimationInput = document.getElementById('estimation_montant');

                function toggleEstimation() {
                    if (check.checked) {
                        estimationDiv.style.display = 'none';
                        estimationInput.value = '';
                    } else {
                        estimationDiv.style.display = 'block';
                    }
                }

                check.addEventListener('change', toggleEstimation);
                toggleEstimation();


            }
        );


    </script>

@endsection
