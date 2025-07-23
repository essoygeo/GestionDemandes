@extends('templates.dashboard')

@php
    if(Auth::user()->role === 'Admin'){
        $title = 'Admin dashboard';
    } elseif(Auth::user()->role === 'Comptable'){
        $title = 'Comptable dashboard';
    } else {
        $title = 'Employé dashboard';
    }
@endphp

@section('title', $title)

@section('content')
    <h2>Bienvenue {{ Auth::user()->nom }} !</h2>
@endsection
