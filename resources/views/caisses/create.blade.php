@extends('layouts.app')
@section('title','creer une caisse ')
@section('content')
    <div class=" row mb-4 d-flex justify-content-center align-items-center bg-light">
        <div class="mb-3 text-end">
            <span class="fw-bold">Montant actuel dans la caisse :</span>
            <span class="badge bg-success fs-5">{{ number_format($caisse->montant_init, 2, ',', ' ') }} CFA</span>
        </div>

        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire d'ajout de montant </h3>

            <form method="POST" action="{{ route('update.caisse',['caisse'=> $caisse->id]) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class=" col-md-12 mb-3">
                        <label for="montant_init" class="form-label">Montant </label>
                        <input type="number" step="0.01" min="0" class="form-control" name="montant_init"
                               id="montant_init"  placeholder="saisir montant en cfa">
                    </div>
                </div>


                <button type="submit" class="btn  btn-success w-100" id="btn">
                    Ajouter montant
                </button>

            </form>
        </div>
    </div>
    <div class="row-gap-md-2">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white">
                <h5 class="mb-3">Historique de caissse</h5>
                {{--                <a class="mb-0 btn btn-sm btn-outline-success " href="#" data-bs-toggle="modal" data-bs-target="#showModalTransaction">voir historique caisse</a>--}}
            </div>
            <div class="card-body">

                <div class="mb-5">
                    <label for="searchInput">Rechercher:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder=" Rechercher...">
                </div>


                <div class="table-responsive" style="overflow: visible;">
                    <table class="table table-hover  align-middle" id="dataTable">
                        <thead class="table-light">
                        <tr>
                            <th class="text-primary-emphasis text-center align-middle">N°</th>
                            <th class="text-primary-emphasis text-center align-middle">Opérateur</th>
                            <th class="text-primary-emphasis text-center align-middle">Type transaction</th>
                            <th class="text-primary-emphasis text-center align-middle">Motif</th>
                            <th class="text-primary-emphasis text-center align-middle">Montant </th>
                            <th class="text-primary-emphasis text-center align-middle">Date</th>
                            <th class="text-primary-emphasis text-center align-middle">Demande associée</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user->nom ?? '-' }}</td>
                                @if($transaction->type==='Entree')
                                    <td class="text-success">{{ $transaction->type }}</td>
                                @else
                                    <td class="text-danger">{{ $transaction->type }}</td>
                                @endif

                                <td>{{ $transaction->motif }}</td>
                                <td>{{ number_format($transaction->montant_transaction, 2, ',', ' ') }} CFA</td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if(isset($transaction->demande))
                                        <a class="text-success"
                                           href="{{route('show.demandes',['demande'=>$transaction->demande->id])}}">voir</a>
                                    @else
                                        <small class="text-muted">Aucune</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    {{ $transactions->links('pagination::bootstrap-5') }}
                    {{--                        modalTransaction--}}
                    {{--                    <div class="modal fade" id="showModalTransaction" tabindex="-1"--}}
                    {{--                         aria-labelledby="showModalTransaction" aria-hidden="true">--}}
                    {{--                        <div class="modal-dialog modal-lg">--}}
                    {{--                            <div class="modal-content">--}}

                    {{--                                <div class="modal-header bg-success-subtle">--}}
                    {{--                                    <h5 class="modal-title" id="showModalTransaction">Les transactions de la caisse--}}
                    {{--                                    </h5>--}}
                    {{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
                    {{--                                            aria-label="Fermer"></button>--}}
                    {{--                                </div>--}}

                    {{--                                <div class="modal-body p-3">--}}

                    {{--                                    <div class="mb-3">--}}
                    {{--                                        <label for="searchInput">Rechercher :</label>--}}
                    {{--                                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">--}}
                    {{--                                    </div>--}}

                    {{--                                    <!-- Conteneur scrollable -->--}}
                    {{--                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">--}}
                    {{--                                        <table class="table table-hover align-middle" id="dataTable">--}}
                    {{--                                            <thead class="table-light sticky-top bg-white" style="top: 0; z-index: 10;">--}}
                    {{--                                            <tr>--}}
                    {{--                                                <th class="text-primary-emphasis">N°</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Responsable</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Type transaction</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Motif</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Montant</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Date</th>--}}
                    {{--                                                <th class="text-primary-emphasis">Demande associée</th>--}}
                    {{--                                            </tr>--}}
                    {{--                                            </thead>--}}
                    {{--                                            <tbody>--}}
                    {{--                                            @foreach($transactions as $transaction)--}}
                    {{--                                                <tr>--}}
                    {{--                                                    <td>{{ $transaction->id }}</td>--}}
                    {{--                                                    <td>{{ $transaction->user->nom ?? '-' }}</td>--}}
                    {{--                                                    @if($transaction->type==='Entree')--}}
                    {{--                                                        <td class="text-success">{{ $transaction->type }}</td>--}}
                    {{--                                                    @else--}}
                    {{--                                                        <td class="text-danger">{{ $transaction->type }}</td>--}}
                    {{--                                                    @endif--}}

                    {{--                                                    <td>{{ $transaction->motif }}</td>--}}
                    {{--                                                    <td>{{ number_format($transaction->montant_transaction, 0, ',', ' ') }} FCFA</td>--}}
                    {{--                                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>--}}
                    {{--                                                    <td>--}}
                    {{--                                                        @if(isset($transaction->demande))--}}
                    {{--                                                            {{ $transaction->demande }}--}}
                    {{--                                                        @else--}}
                    {{--                                                            <small class="text-muted">Aucune</small>--}}
                    {{--                                                        @endif--}}
                    {{--                                                    </td>--}}
                    {{--                                                </tr>--}}
                    {{--                                            @endforeach--}}
                    {{--                                            </tbody>--}}
                    {{--                                        </table>--}}
                    {{--                                    </div>--}}

                    {{--                                    <!-- Pagination en dehors du scroll -->--}}
                    {{--                                    <div class="d-flex justify-content-center mt-3">--}}
                    {{--                                        {{ $transactions->links('pagination::bootstrap-5') }}--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}

                    {{--                                <script>--}}
                    {{--                                    document.addEventListener('DOMContentLoaded', function () {--}}
                    {{--                                        const searchInput = document.getElementById('searchInput');--}}
                    {{--                                        const rows = document.querySelectorAll('#dataTable tbody tr');--}}

                    {{--                                        searchInput.addEventListener('input', function () {--}}
                    {{--                                            const searchValue = searchInput.value.toLowerCase();--}}
                    {{--                                            rows.forEach(row => {--}}
                    {{--                                                const rowText = row.textContent.toLowerCase();--}}
                    {{--                                                row.style.display = rowText.includes(searchValue) ? '' : 'none';--}}
                    {{--                                            });--}}
                    {{--                                        });--}}
                    {{--                                    });--}}
                    {{--                                </script>--}}


                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}


                    {{--                    <div class="d-flex justify-content-center pagin mt-3">--}}
                    {{--                        {{ $categories->links('pagination::bootstrap-5') }}--}}

                    {{--                    </div>--}}
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
                    {{--const btn  = document.getElementById('btn');--}}
                    {{--const inputmontant = document.getElementById('montant_init');--}}

                    {{--const mtnActu = parseFloat({{$caisse->montant_init}});--}}

                    {{--inputmontant.addEventListener('input',function(){--}}
                    {{--    if(mtnActu > parseFloat(this.value)){--}}
                    {{--         btn.disabled =  true;--}}
                    {{--    }--}}
                    {{--    else{--}}
                    {{--        btn.disabled = false;--}}
                    {{--    }--}}
                    {{--})--}}

                }
            );


        </script>
    </div>

@endsection
