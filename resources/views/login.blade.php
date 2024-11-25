@extends('layouts.layout')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container">
    <h2>Iniciar Sesión</h2>
    
    @if (session('alert'))
        <div class="alert alert-danger">
            {{ session('alert') }}
        </div>
    @endif

    <form method="post" action="{{ route('users.login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
            @if ($errors->has('email'))
                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @if ($errors->has('password'))
                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        <a href="/register" class="btn btn-primary btn-xs ml-2">Registrarse</a>
    </form>
</div>
@endsection
