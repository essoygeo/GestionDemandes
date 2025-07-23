@extends('templates.dashboard')
@section('title','Liste des categories')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-3">Liste des categories</h5>
            <a class="mb-0 btn btn-sm btn-outline-violet " href="{{route('create.categories')}}">+ Creer categorie</a>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <label for="searchInput">Rechercher:</label>
                <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
            </div>


            <div class="table-responsive">
                <table class="table table-hover  align-middle" id="dataTable">
                    <thead class="table-light">
                    <tr>
                        <th class="text-primary-emphasis">N°</th>
                        <th class="text-primary-emphasis">Nom</th>
                        <th class="text-primary-emphasis">Createur</th>
                        <th class="text-primary-emphasis">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->nom }}</td>
                            <td>{{ $categorie->user->nom }}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-violet dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item violet" href="{{ route('show.categories', $categorie->id) }}">
                                                <i class="fa-solid fa-eye me-1 violet"></i> Voir
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item violet" href="{{ route('edit.categories', $categorie->id) }}">
                                                <i class="fas fa-edit me-1 violet"></i> Modifier
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('destroy.categories', $categorie->id) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer cette demande ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center pagin mt-3">
                    {{ $categories->links('pagination::bootstrap-5') }}

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
