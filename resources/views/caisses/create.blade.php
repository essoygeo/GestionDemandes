@extends('layouts.app')
@section('title','creer une caisse ')
@section('content')
    <div class=" row mb-4 d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de rechargement </h3>

            <form method="POST" action="{{ route('update.caisse',['caisse'=> $caisse->id]) }}">
                @method('PUT')
                @csrf
                  <div class="row">
                <div class=" col-md-6 mb-3">
                    <label for="montant_init" class="form-label">Montant </label>
                    <input type="number" step="0.01" min="0" class="form-control" name="montant_init" id="montant_init" value="{{$caisse->montant_init}}"  placeholder="saisir montant initial en cfa"  >
                </div>
                <div class=" col-md-6 mb-3">
                    <label for="date" class="form-label">Date de création</label>
                    <input type="date" class="form-control" name="date" id="date"  value="{{$caisse->date}}" required>
                </div>
                  </div>


                <button type="submit" class="btn  btn-success w-100" >
                    charger un montant
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-3">LA CAISSE</h5>
{{--                <a class="mb-0 btn btn-sm btn-outline-success " href="{{route('create.categories')}}">+ Creer categorie</a>--}}
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
                            <th class="text-primary-emphasis">N°</th>
                            <th class="text-primary-emphasis">Chargé par</th>
                            <th class="text-primary-emphasis">Montant actuel</th>
                            <th class="text-primary-emphasis">Date Creation</th>
                            <th class="text-primary-emphasis">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($caisse)
                            <tr>
                                <td>{{ $caisse->id }}</td>
                                <td>{{ $caisse->user->nom }}</td>
                                <td>{{ $caisse->montant_init }} CFA</td>
                                <td>{{ $caisse->date}}</td>

                                <td>
                                    <div class="dropup">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-target="#showModalCaisse{{$caisse->id}}" data-bs-toggle="modal">
                                                    <i class="fa-solid fa-eye me-1 text-success"></i> Voir
                                                </a>
                                            </li>
{{--                                            <li>--}}
{{--                                                <a class="dropdown-item" href="#" data-bs-target="#editModalCaisse{{$caisse->id}}" data-bs-toggle="modal">--}}
{{--                                                    <i class="fas fa-edit me-1 text-success"></i> Modifier--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li>--}}
{{--                                                <form action="{{ route('destroy.categories', $caisse->id) }}" method="POST"--}}
{{--                                                      onsubmit="return confirm('Supprimer cette demande ?');">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    <button class="dropdown-item text-danger" type="submit">--}}
{{--                                                        <i class="fas fa-trash-alt me-1"></i> Supprimer--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                              @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted text-primary-emphasis">Aucune caisse enregistrée.</td>
                                </tr>
                            @endif
{{--                        modal show caisse--}}
                            <div class="modal fade" id="showModalCaisse{{ $caisse->id }}" tabindex="-1"
                                 aria-labelledby="showModalCaisse" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header bg-success-subtle">
                                            <h5 class="modal-title" id="showModalCaisse">Détails de la
                                                caisse </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Fermer"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div>
                                                <h3 class="text-center mb-4">Details caisse
                                                </h3>

                                                <div>
                                                    <form>



                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="createur" class="form-label">
                                                                    Chargé par:</label>
                                                                <input type="text" class="form-control"
                                                                       name="createur"
                                                                       id="createur"
                                                                       value="{{ $caisse->user->nom }}" readonly>
                                                            </div>

                                                            <div class=" col-md-6 mb-3">
                                                                <label for="montant_init" class="form-label">Montant initial</label>
                                                                <input type="number" step="0.01" min="0" class="form-control" name="montant_init" id="montant_init"  value="{{$caisse->montant_init}}" readonly >
                                                            </div>
                                                        </div>


                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="date" class="form-label">Date
                                                                        création</label>
                                                                    <input type="date" class="form-control"
                                                                           name="date"
                                                                           id="date"
                                                                           value="{{ $caisse->date }}" readonly>
                                                                </div>
                                                            </div>


                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
{{--                        modalEditCaisse--}}
{{--                            <div class="modal fade" id="editModalCaisse{{ $caisse->id }}" tabindex="-1"--}}
{{--                                 aria-labelledby="editModalCaisse" aria-hidden="true">--}}
{{--                                <div class="modal-dialog modal-lg">--}}
{{--                                    <div class="modal-content">--}}

{{--                                        <div class="modal-header bg-success-subtle">--}}
{{--                                            <h5 class="modal-title" id="editModalCaisse">formulaire de modification--}}
{{--                                                 </h5>--}}
{{--                                            <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--                                                    aria-label="Fermer"></button>--}}
{{--                                        </div>--}}

{{--                                        <div class="modal-body">--}}
{{--                                            <div>--}}
{{--                                                <h3 class="text-center mb-4">Modifier Caisse--}}
{{--                                                </h3>--}}

{{--                                                <div>--}}
{{--                                                    <form action="{{route('update.caisse',['caisse'=>$caisse->id])}}" method="post">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('PUT')--}}
{{--                                                        <div class="row">--}}


{{--                                                            <div class=" col-md-6 mb-3">--}}
{{--                                                                <label for="montant_init" class="form-label">Montant initial</label>--}}
{{--                                                                <input type="number" step="0.01" min="0" class="form-control" name="montant_init" id="montant_init"  value="{{$caisse->montant_init}}" required >--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-md-6 mb-3">--}}
{{--                                                                <label for="date" class="form-label">Date--}}
{{--                                                                    création</label>--}}
{{--                                                                <input type="date" class="form-control"--}}
{{--                                                                       name="date"--}}
{{--                                                                       id="date"--}}
{{--                                                                       value="{{ $caisse->date }}" >--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}




{{--                                                        <button type="submit" class="btn  btn-success w-100" >--}}
{{--                                                            modifier--}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center pagin mt-3">
{{--                        {{ $categories->links('pagination::bootstrap-5') }}--}}

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
    </div>

@endsection
