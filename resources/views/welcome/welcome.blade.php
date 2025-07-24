@extends('layouts.app')



@section('title','Gestion des demandes')

@section('content')
    <h2>Bienvenue {{ Auth::user()->nom }} !</h2>
@endsection
