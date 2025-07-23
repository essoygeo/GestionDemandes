@extends('templates.dashboard')
@section('title','creer une categorie')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
        <h3 class="text-center mb-4"> Formulaire de creation</h3>

        <form method="POST" action="{{ route('store.categories') }}">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom categorie</label>
                <input type="text" class="form-control" name="nom" id="nom"  placeholder="saisir nom categorie" required >
            </div>



            <button type="submit" class="btn  btn-violet w-100" >
                creer
            </button>
        </form>
    </div>
</div>

@endsection
