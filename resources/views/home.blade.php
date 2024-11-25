@extends('layouts.layout')

@section('title', 'Home')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<header class="text-center">
    <h1>Bienvenido a PapuMusic {{ Auth::user()->name }}</h1>
</header>
<main>
    <!-- Main content here -->
</main>
@endsection