@extends('layouts.app')
@section('title','creer une caisse ')
@section('content')
    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de creation</h3>

            <form method="POST" action="{{ route('store.caisse') }}">
                @csrf
                  <div class="row">
                <div class=" col-md-6 mb-3">
                    <label for="montant_init" class="form-label">Montant initial</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="montant_init" id="montant_init"  placeholder="saisir montant initial en cfa" required >
                </div>
                <div class=" col-md-6 mb-3">
                    <label for="date" class="form-label">Date de création</label>
                    <input type="date" class="form-control" name="date" id="date"  value="{{old('date')}}" required>
                </div>
                  </div>


                <button type="submit" class="btn  btn-success w-100" >
                    creer
                </button>
            </form>
        </div>
    </div>

@endsection
