@extends('layouts.app')

@section('title', 'Gestion des demandes')

@section('content')
    <h2>Bienvenue {{ Auth::user()->nom }} !</h2>

    {{-- Dashboard Employé --}}

    <div class="row mt-4">
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
                    <h5 class="card-title">Ressources créées</h5>
                    <p class="card-text fs-3">{{ $ressources }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x float-end"></i>
                    <h5 class="card-title">Demandes validées</h5>
                    <p class="card-text fs-3">{{ $validees }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-2x float-end"></i>
                    <h5 class="card-title">Demandes refusées</h5>
                    <p class="card-text fs-3">{{ $refusees }}</p>
                </div>
            </div>
        </div>
    </div>


    <h5 class="mt-4 mb-3 fw-bold">Liste des 5 dernières demandes</h5>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>N°</th>
            <th>Titre</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($last_demandes as $d)
            <tr>
                <td>{{ $d->id }}</td>
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
