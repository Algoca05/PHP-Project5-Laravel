@extends('layouts.layout')

@section('title', 'Admin Management')

@section('content')
<h1 class="text-2xl">Panel de Control de Usuarios</h1>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table class="table">
    <thead>
        <tr>
            <th>Eliminar</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Actualizar Rol</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <form method="post" action="{{ route('delete_user', $user->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn text-red-600 text-bold btn-lg">X</button>
                    </form>
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                <td>
                    <form method="post" action="{{ route('update_user_role', $user->id) }}">
                        @csrf
                        <select name="role" class="form-control">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>User</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Actualizar Rol</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection