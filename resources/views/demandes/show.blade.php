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
                    <strong>Raison :</strong> {{ $demande->raison }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Coût estimé:</strong>
                    @if(isset($demande->estimation_montant))
                        <span class="text-primary fw-semibold">{{ $demande->estimation_montant }} CFA</span>
                    @else
                        <strong class=" text-primary-emphasis">Aucune estimation définie</strong>
                    @endif

                </div>
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
                    <strong>Date :</strong> {{ $demande->date}}
                </div>
                <div class="col-md-6 ">
                    <strong>Montant actuel de la caisse :</strong>
                    @if(isset($demande->estimation_montant))
                        @if($caisse_mtn_actuel > $demande->estimation_montant)
                            <span class="text-success fw-semibold">{{ $caisse_mtn_actuel}} CFA</span>


                        @elseif($caisse_mtn_actuel < $demande->estimation_montant )
                                <sapn class="text-danger fw-semibold ">{{ $caisse_mtn_actuel}} CFA</sapn>
                        @else
                            <sapn class="text-primary fw-semibold ">{{ $caisse_mtn_actuel}} CFA</sapn>
                        @endif




                    @else
                        <strong>{{ $caisse_mtn_actuel}} CFA</strong>
                    @endif

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
                            <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Date
                                creation
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
                                        <small class="text-primary-emphasis">pas de model</small>
                                    @else
                                        {{$ressource->marque}}
                                    @endif

                                </td>
                                <td class="text-center align-middle">
                                    @if(strcasecmp($ressource->categorie->nom, 'logicielle') === 0)
                                        <small class="text-primary-emphasis">pas de marque</small>
                                    @else
                                        {{$ressource->model}}
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{$ressource->date}}</td>
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
                                                        <a class="dropdown-item"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#showRessourceModal{{$ressource->id}}">
                                                            <i class="fa-solid fa-eye me-1 text-success"></i> Voir
                                                        </a>
                                                    </li>
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
                                                    <a class="dropdown-item"
                                                       href="#"

                                                    >
                                                        <i class="fa-solid fa-check text-success"></i> A payer
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="#"

                                                    >
                                                        <i class="fa-solid fa-box text-primary"></i> En stock
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="#"
                                                    >
                                                        <i class="fa-solid fa-x text-danger"></i> Ne pas payer
                                                    </a>
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
                                                                <input type="date" class="form-control"
                                                                       name="date_ressource"
                                                                       id="date_ressource"
                                                                       value="{{ $ressource->date }}" readonly>
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
                                            <h5 class="modal-title" id="voirRessourceModalLabel">Formulaire de
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
                                                                       value="{{ $ressource->date }}">
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
        });
    </script>

@endsection
