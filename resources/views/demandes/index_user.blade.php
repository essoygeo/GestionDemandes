@extends('layouts.app')
@section('title','Liste de mes demandes')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-3">Liste de mes demandes</h5>
            <a class="mb-0 btn btn-sm btn-outline-success " href="{{route('create.demandes')}}">+ Creer demande</a>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <label for="searchInput">Rechercher:</label>
                <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
            </div>

            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-hover align-middle" id="dataTable">
                    <thead class="table-light">
                    <tr>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">N°</th>
{{--                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Categorie</th>--}}
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Creatueur</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Titre demande</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 200px;">Raison demande</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Type demande</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Coût estimé</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Date creation</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">status</th>
                        <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($demandes as $demande)
                        <tr>
                            <td>{{ $demande->id }}</td>
{{--                            <td>{{ $demande->categorie->nom }}</td>--}}
                            <td>{{ $demande->user->nom }}</td>


                            <td class="text-center align-middle" >
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="text-truncate "
                                          style="max-width: 220px;">{{ Str::limit($demande->titre, 30) }}</span>
                                    <a href="" class="text-success-emphasis"
                                       data-bs-toggle="modal"
                                       data-bs-target="#titreModal{{ $demande->id }}">
                                        <small>Lire plus</small>
                                    </a>
                                </div>


                                <div class="modal fade" id="titreModal{{ $demande->id }}" tabindex="-1"
                                     aria-labelledby="titreModalLabel{{ $demande->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success-subtle text-white">
                                                <h5 class="modal-title" id="titreModalLabel{{ $demande->id }}">Titre
                                                    complet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">{{ $demande->titre }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="text-truncate"
                                          style="max-width: 220px;">{{ Str::limit($demande->raison, 30) }}</span>
                                    <a class="text-success-emphasis"
                                       href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#raisonModal{{ $demande->id }}">
                                        <small>Lire plus</small>
                                    </a>


                                </div>


                                <div class="modal fade" id="raisonModal{{ $demande->id }}" tabindex="-1"
                                     aria-labelledby="raisonModalLabel{{ $demande->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success-subtle text-white">
                                                <h5 class="modal-title" id="raisonModalLabel{{ $demande->id }}">Raison
                                                    complète</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">{{ $demande->raison }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center align-middle">{{ $demande->type }}</td>
                            <td class="text-center align-middle">
                                @if($demande->type ==='En stock')
                                    <small class="text-primary-emphasis">pas de coût</small>
                                @else
                                    {{$demande->estimation_montant}} CFA
                                @endif

                            </td>
                            <td class="text-center align-middle">{{ $demande->date }}</td>
                            <td class="text-center align-middle">
                                @if($demande->status === 'En attente')
                                    <span class="badge bg-warning">{{ $demande->status }}</span>
                                @elseif($demande->status === 'Refusé')
                                    <span class="badge bg-danger">{{ $demande->status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $demande->status }}</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropup">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                        Actions
                                    </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if($demande->status ==='En attente')
                                        <li>
                                            <a class="dropdown-item " href="{{ route('show.demandes', $demande->id) }}">
                                                <i class="fa-solid fa-eye me-1 text-success"></i> Voir
                                            </a>
                                        </li>
                                        <li >
                                            <a class="dropdown-item " href="{{ route('edit.demandes', $demande->id) }}">
                                                <i class="fas fa-edit me-1 text-success"></i> Modifier
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('destroy.demandes', $demande->id) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer cette demande ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    @elseif(Auth::user()->role === 'Admin')
                                        <li>
                                        <form action="{{ route('destroy.demandes', $demande->id) }}" method="POST"
                                              onsubmit="return confirm('Supprimer cette demande ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="fas fa-trash-alt me-1"></i> Supprimer
                                            </button>
                                        </form>
                                        </li>

                                    @endif
                                        <li>
                                            <a class="dropdown-item " href="{{ route('show.demandes', $demande->id) }}">
                                                <i class="fas fa-comments me-1 text-success "></i> Commenter
                                            </a>
                                        </li>
                                </ul>
                                </div>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center pagin mt-3">
                    {{ $demandes->links('pagination::bootstrap-5') }}
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
