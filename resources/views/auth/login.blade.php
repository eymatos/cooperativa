<!DOCTYPE html>
<html>
<head>
    <title>Login Cooperativa</title>
</head>
<body>

<h2>Ingreso</h2>

@if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <input type="text" name="cedula" placeholder="Cédula"><br><br>
    <input type="password" name="password" placeholder="Contraseña"><br><br>
    <button type="submit">Ingresar</button>
</form>

</body>
</html>
