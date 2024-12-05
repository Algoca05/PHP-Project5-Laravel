
<div>
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
                        <button wire:click="deleteUser({{ $user->id }})" class="btn text-red-600 text-bold btn-lg">X</button>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                    <td>
                        <select wire:change="updateUserRole({{ $user->id }}, $event.target.value)" class="form-control">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>User</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>