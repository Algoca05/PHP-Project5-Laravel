<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top w-100">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('music') }}">Musica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Opción 2</a>
                </li>
            </ul>
            <header class="text-center">
                <h1 class = "text-3xl">Admin Management</h1>
            </header>
            <ul class="navbar-nav ml-auto">
                @if(Auth::user()->role == 1)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user_management') }}">Panel de Control</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="#">Editar Perfil</a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container  ">
    <h1 class = "text-2xl">Panel de Control de Usuarios</h1>
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
                <th>Actualizar Rol</th> <!-- Add this line -->
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
                    </td >
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
</div>
</body>
</html>