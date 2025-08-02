@extends('layouts.app')

@section('title', 'Gestion des demandes')

@section('content')
    <h2>Bienvenue {{ Auth::user()->nom }} !</h2>



        {{-- Dashboard Comptable et Admin --}}
        <div class=" d-flex justify-content-end mb-3">

           <a  class="text-secondary text-decoration-none" href="{{route('employe.dashboard')}}"> <i class="fas fa-user me-1"></i> mon dashboard personnel</a>
        </div>
        {{-- Deuxième ligne de cartes --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <i class="fas fa-hourglass-half fa-2x float-end"></i>
                        <h5 class="card-title">Demandes en attente</h5>
                        <p class="card-text fs-3">{{ $en_attente }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-2x float-end"></i>
                        <h5 class="card-title">Total ressources</h5>
                        <p class="card-text fs-3">{{ $ressources }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x float-end"></i>
                        <h5 class="card-title"> Demandes validées</h5>
                        <p class="card-text fs-3">{{ $validees }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <i class="fas fa-times-circle fa-2x float-end"></i>
                        <h5 class="card-title"> Demandes refusées</h5>
                        <p class="card-text fs-3">{{ $refusees }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            {{-- Carte : Montant initial dans la caisse --}}
            <div class="col-md-4">
                <div class="card text-white mb-3" style="background-color: #235e49">
                    <div class="card-body text-center">
                        <i class="fa fas fa-wallet fa-2x float-end"></i>
                        <h5 class="card-title">Montant actuel dans la caisse</h5>
                        <p class="fs-2 fw-bold fs-3">{{ number_format($caisse->montant_init, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>




            {{-- Carte : Total des dépenses --}}
            <div class="col-md-4 ">
                <div class="card text-white mb-3" style="background-color: #c21f1f">
                    <div class="card-body text-center">
                        <i class="fa fas fas fa-dollar-sign fa-2x float-end"></i>
                        <h5 class="card-title ">Total des dépenses</h5>
                        <p class="fs-2 fw-bold fs-3 ">{{ number_format($total_depenses, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
            {{-- Carte : Nombre total de demandes --}}
            <div class="col-md-4">
                <div class=" card text-white bg-info mb-3">
                    <div class="card-body text-center ">
                        <i class="fa fas fa-clipboard-list fa-2x float-end"></i>
                        <h5 class="card-title">Nombre total de demandes</h5>
                        <p class="fs-2 fw-bold fs-3">{{ $totaldemandes }}</p>

                    </div>
                </div>
            </div>
        </div>




        <h5 class="mt-4 mb-3 fw-bold">Liste des 5 dernières demandes</h5>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>N°</th>
                <th>Demandeur</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Date</th>

            </tr>
            </thead>
            <tbody>
            @foreach($last_demandes as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->user->nom ?? 'N/A' }}</td>
                    <td>{{ $d->titre }}</td>
                    <td><span class="badge bg-{{ $d->status_color }}">{{ $d->status }}</span></td>
                    <td>{{ $d->created_at->format('d/m/Y') }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="max-width: 580px; margin: auto;">
            <canvas id="statutChart"></canvas>
        </div>



@endsection





@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById("statutChart"), {
            type: 'pie',
            data: {
                labels: ['En attente', 'Validée', 'Refusée'],
                datasets: [{
                    data: [{{ $en_attente }}, {{ $validees }}, {{ $refusees }}],
                    backgroundColor: ['#fdb10d', '#198754', '#dc3545']
                }]
            }
        });
    </script>

@endsection
