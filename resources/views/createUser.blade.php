<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Registrarse</h2>
    <form method="post" action="{{ route('users.register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" >
            @if ($errors->has('name'))
                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" >
            @if ($errors->has('email'))
                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" >
            @if ($errors->has('password'))
                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <a href="/login" class="btn btn-secondary">Iniciar Sesión</a>
        </div>
    </form>
</div>
<script>
    @if (session('registered'))
        window.onload = function() {
            document.getElementById('email').value = "{{ session('email') }}";
            document.getElementById('password').value = "{{ session('password') }}";
            document.forms[0].submit();
        }
    @endif
</script>
</body>
</html>



